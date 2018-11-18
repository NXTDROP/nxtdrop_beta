<?php

    session_start();
    $db = '../../dbh.php';
    include $db;
    include('../../../credentials.php');
    include('../../vendor/autoload.php');
    include('../../email/Email.php');
    require_once('../currencyConversion.php');
    date_default_timezone_set("UTC");
    $purchaseDate = date("Y-m-d H:i:s", time());
    \Stripe\Stripe::setApiKey($STRIPE_LIVE_SECRET_KEY);

    $item_ID = $_POST['item_ID'];
    $fullAddress = $_POST['shippingAddress'];
    $totalPrice = $_POST['totalPrice'];
    $shippingCost = $_POST['shippingCost'];
    $n_id = $_SESSION['uid'];
    $s_id = $_SESSION['stripe_acc'];
    $cus_id = $_SESSION['cus_id'];

    if(!isset($_SESSION['uid'])) {
        echo 'ERROR 101';
    }
    else {
        /** TransactionID**, itemID**, sellerID**, buyerID**, middlemanID, status, purchaseDate**, confirmationDate and verificationDate */
        //GET BUYER ID
        $buyerID = $n_id;

        //GET SELLER INFO
        $result = $conn->query("SELECT users.uid, users.username, users.email, offers.price FROM offers, users WHERE offers.offerID = '$item_ID' AND offers.sellerID = users.uid;");
        $row = $result->fetch_assoc();

        $seller_ID = $row['uid'];
        $sellerEmail = $row['email'];
        $sellerUsername = $row['username'];
        $price = $row['price'];
        $status = "waiting shipment";

        if($_SESSION['country'] == 'US') {
            $totalPrice = $totalPrice;
        } elseif ($_SESSION['country'] == 'CA') {
            $totalPrice = cadTousd($totalPrice, $db, false);
            $shippingCost = 13.65;
        } else {
            $totalPrice = $totalPrice;
        }

        $conn->autocommit(false);

        //CREATE TRANSACTION
        $addTransaction = $conn->query("INSERT INTO transactions (itemID, sellerID, shippingAddress, buyerID, status, purchaseDate, totalPrice) VALUES ('$item_ID', '$seller_ID', '$fullAddress', '$buyerID', '$status', '$purchaseDate', '$totalPrice');");

        //GET TRANSACTIONID JUST CREATED ABOVE
        $getTID = $conn->query("SELECT transactionID FROM transactions WHERE itemID = '$item_ID' AND sellerID = '$seller_ID' AND purchaseDate = '$purchaseDate';");
        $data = $getTID->fetch_assoc();
        $transactionID = $data['transactionID'];

        //CREATE SHIPMENT
        $addShipping = $conn->query("INSERT INTO shipping (transactionID, cost) VALUES ('$transactionID', '$shippingCost');");

        //CREATE NOTIFICATION
        $addNotification = $conn->query("INSERT INTO notifications (post_id, user_id, target_id, notification_type, date) VALUES ('$item_ID', '$n_id', '$seller_ID', 'item sold', '$purchaseDate')");

        //ADD DISCOUNT IF USED
        if(isset($_POST['discountID'])) {
            $discountID = $_POST['discountID'];
            $addDiscount = $conn->query("INSERT INTO discountUsed (ID, usedBy, dateUsed, transactionID) VALUES ('$discountID', '$n_id', '$purchaseDate', '$transactionID');");
        } else {
            $addDiscount = true;
        }


        //CHECK IF DATA WAS INSERTED IN DB IF NOT ROLLBACK AND PRINT ERROR, OTHERWISE COMMIT, SEND EMAIL TO BUYER AND PRINT TID
        if($addShipping && $addTransaction && $addDiscount && $addNotification) {
            
            try {
                // Use Stripe's library to make requests...
                $amount = $totalPrice * 100;
                $charge = \Stripe\Charge::create(array(
                    "amount" => $amount,
                    "currency" => "usd",
                    "customer" => $cus_id,
                    "on_behalf_of" => $s_id,
                    "transfer_group" => $transactionID,
                    "capture" => false
                ));

                $chargeDate = date("Y-m-d H:i:s", time());
                $chargeID = $charge->id;
                $conn->query("UPDATE transactions SET chargeID = '$chargeID', chargeDate = '$chargeDate' WHERE transactionID = '$transactionID'");
                
                //SEND EMAIL TO BUYER
                $username = $_SESSION['username'];
                $buyerEmail = $_SESSION['email'];
                $email = new Email($username, $buyerEmail, 'stripeusa@nxdrop.com', 'Your NXTDROP Receipt [ORDER #'.$transactionID.']', '');
                $email->setTransactionID($transactionID);
                $email->sendEmail('orderPlaced');

                //SEND EMAIL TO SELLER
                $email = new Email($sellerUsername, $sellerEmail, 'stripeusa@nxdrop.com', 'Congratulations, your item SOLD!', '');
                $email->setTransactionID($transactionID);
                $email->sendEmail('sellerConfirmation');

                //SEND ALERT EMAIL
                $email = new \SendGrid\Mail\Mail(); 
                $email->setFrom("stripeusa@nxtdrop.com", "NXTDROP PAYMENTS");
                $email->setSubject("Transaction #".$transactionID."");
                $email->addTo('admin@nxtdrop.com', 'NXTDROP TEAM');
                $html = "<p>".$username." bought an item. Order #".$transactionID.", Total Price: ".$totalPrice.".</p>";
                $email->addContent("text/html", $html);
                $sendgrid = new \SendGrid($SD_TEST_API_KEY);
                try {
                    $sendgrid->send($email);
                    $conn->commit();
                    die($transactionID);
                } catch (Exception $e) {
                    //PRINT TID
                    $conn->commit();
                    die($transactionID);
                }
            } catch(\Stripe\Error\Card $e) {
                // Since it's a decline, \Stripe\Error\Card will be caught
                $conn->rollback();
                $body = $e->getJsonBody();
                $err  = $body['error'];
                $log = 'Status is:' . $e->getHttpStatus() . "\n" . 'Type is:' . $err['type'] . "\n" . 'Code is:' . $err['code'] . "\n" . 'Message is:' . $err['message'] . "\n" . 'Date:' . date("Y-m-d H:i:s", time());
                $email = new \SendGrid\Mail\Mail(); 
                $email->setFrom("admin@nxtdrop.com", "NXTDROP");
                $email->setSubject("URGENT! Error PO.");
                $email->addTo('momar@nxtdrop.com', 'MOMAR CISSE');
                $html = "<p>".$log."<br> Card Declined. Username: ".$_SESSION['username'].", itemID: ".$item_ID.", totalPrice: ".$totalPrice."</p>";
                $email->addContent("text/html", $html);
                $sendgrid = new \SendGrid($SD_TEST_API_KEY);
                try {
                    $response = $sendgrid->send($email);
                } catch (Exception $e) {
                    die('CARD');
                }

                die('CARD');
            } catch (\Stripe\Error\RateLimit $e) {
                // Too many requests made to the API too quickly
                $conn->rollback();
                errorLog($e);
                echo 'DB';
            } catch (\Stripe\Error\InvalidRequest $e) {
                // Invalid parameters were supplied to Stripe's API
                $conn->rollback();
                errorLog($e);
                echo 'DB';
            } catch (\Stripe\Error\Authentication $e) {
                // Authentication with Stripe's API failed
                // (maybe you changed API keys recently)
                $conn->rollback();
                $body = $e->getJsonBody();
                $err  = $body['error'];
                $log = 'Status is:' . $e->getHttpStatus() . "\n" . 'Type is:' . $err['type'] . "\n" . 'Code is:' . $err['code'] . "\n" . 'Message is:' . $err['message'] . "\n" . 'Date:' . date("Y-m-d H:i:s", time());
                $email = new \SendGrid\Mail\Mail(); 
                $email->setFrom("admin@nxtdrop.com", "NXTDROP");
                $email->setSubject("URGENT! Error PO.");
                $email->addTo('momar@nxtdrop.com', 'MOMAR CISSE');
                $html = "<p>".$log."<br> Cannot connect to Stripe. Authentication Problem.</p>";
                $email->addContent("text/html", $html);
                $sendgrid = new \SendGrid($SD_TEST_API_KEY);
                try {
                    $response = $sendgrid->send($email);
                } catch (Exception $e) {
                    die('DB');
                }

                die('DB');
            } catch (\Stripe\Error\ApiConnection $e) {
                // Network communication with Stripe failed
                $conn->rollback();
                errorLog($e);
                echo 'DB';
            } catch (\Stripe\Error\Base $e) {
                // Display a very generic error to the user, and maybe send
                // yourself an email
                //SEND ALERT EMAIL
    
                $conn->rollback();
                echo 'DB';
            } catch (Exception $e) {
                // Something else happened, completely unrelated to Stripe
                $conn->rollback();
                echo 'DB';
            }
        }
        else {
            $conn->rollback();
            echo 'ERROR 102';
        }
    }

    function errorLog($e) {
        $log_filename = $_SERVER['DOCUMENT_ROOT']."/log";

        $body = $e->getJsonBody();
        $err  = $body['error'];
        $log = 'Status is:' . $e->getHttpStatus() . "\n" . 'Type is:' . $err['type'] . "\n" . 'Code is:' . $err['code'] . "\n" . 'Message is:' . $err['message'] . "\n" . 'Date:' . date("Y-m-d H:i:s", time());

        if (!file_exists($log_filename))
        {
            // create directory/folder uploads.
            mkdir($log_filename, 0777, true);
        }
        $log_file_data = $log_filename.'/log_' . date('d-M-Y') . '.log';
        file_put_contents($log_file_data, $log . "\n", FILE_APPEND);
    }

?>