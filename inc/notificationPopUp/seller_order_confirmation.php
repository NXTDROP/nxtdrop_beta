<?php

    session_start();

    if(!isset($_SESSION['uid'])) {
        echo 'CONNECT';
    }
    else {
        include '../../dbh.php';
        date_default_timezone_set("UTC");
        $confirmation_date = date("Y-m-d H:i:s", time());
        require_once('../../../credentials.php');
        require_once('../../vendor/autoload.php');
        require_once('../../email/Email.php');
        \Stripe\Stripe::setApiKey($STRIPE_LIVE_SECRET_KEY);
        $resType = $conn->real_escape_string($_POST['resType']);
        $item_ID = $conn->real_escape_string($_POST['item_ID']);
        $buyer_ID = $conn->real_escape_string($_POST['buyer_ID']);
        $seller_ID = $_SESSION['uid'];

        $query = "SELECT * FROM transactions WHERE itemID = '$item_ID' AND sellerID = '$seller_ID' AND buyerID = '$buyer_ID' AND confirmationDate = '0000-00-00 00:00:00'";
        $result = $conn->query($query);
        if(mysqli_num_rows($result) < 1) {
            echo 'SOLD';
        }
        else {
            if($resType === "confirmation") {
                $row = $result->fetch_assoc();
                $transactionID = $row['transactionID'];
                $conn->autocommit(false);
                $updateTrans = $conn->query("UPDATE transactions SET confirmationDate = '$confirmation_date' WHERE itemID = '$item_ID' AND sellerID = '$seller_ID' AND buyerID = '$buyer_ID' AND confirmationDate = '0000-00-00 00:00:00';");
                $deleteNotif = $conn->query("DELETE FROM notifications WHERE post_id = '$item_ID' AND user_id = '$buyer_ID' AND target_id = '$seller_ID';");
                $getBuyerInfo = $conn->query("SELECT * FROM transactions, thebag, users WHERE transactions.transactionID = '$transactionID' AND thebag.uid = transactions.buyerID AND transactions.buyerID = users.uid");

                if($updateTrans && $deleteNotif && $getBuyerInfo) {
                    try {
                        // Use Stripe's library to make requests...
                        $info = $getBuyerInfo->fetch_assoc();
                        $amount = $info['totalPrice'] * 100;
                        $buyerPaymentMethod = $info['cus_id'];
                        $charge = \Stripe\Charge::create(array(
                            "amount" => $amount,
                            "currency" => "usd",
                            "customer" => $buyerPaymentMethod,
                            "on_behalf_of" => $_SESSION['stripe_acc'],
                            "transfer_group" => $transactionID
                        ));
                        $chargeDate = date("Y-m-d H:i:s", time());
                        $chargeID = $charge->id;
                        $conn->query("UPDATE transactions SET chargeID = '$chargeID', chargeDate = '$chargeDate' WHERE transactionID = '$transactionID'");
                        $conn->query("INSERT INTO notifications (post_id, user_id, target_id, notification_type, date) VALUES ('$item_ID', '0', '$seller_ID', 'seller shipping', '$chargeDate');");
                        $conn->commit();

                        //SEND EMAIL TO BUYER
                        $email = new Email($info['username'], $info['email'], 'orders@nxtdrop.com', 'Your order is confirmed', '');
                        $email->setTransactionID($transactionID);
                        $email->sendEmail('orderConfirmation');

                        //SEND EMAIL TO SELLER
                        $email = new Email($_SESSION['username'], $_SESSION['email'], 'orders@nxtdrop.com', 'SALE CONFIRMED!', '');
                        $email->setTransactionID($transactionID);
                        $email->sendEmail('orderConfirmation_seller');
                    } catch(\Stripe\Error\Card $e) {
                        // Since it's a decline, \Stripe\Error\Card will be caught
                        $body = $e->getJsonBody();
                        $err  = $body['error'];
                        $log = 'Status is:' . $e->getHttpStatus() . "\n" . 'Type is:' . $err['type'] . "\n" . 'Code is:' . $err['code'] . "\n" . 'Message is:' . $err['message'] . "\n" . 'Date:' . date("Y-m-d H:i:s", time());
                        $email = new \SendGrid\Mail\Mail(); 
                        $email->setFrom("admin@nxtdrop.com", "NXTDROP");
                        $email->setSubject("URGENT! Error Update User Regis.");
                        $email->addTo('momar@nxtdrop.com', 'MOMAR CISSE');
                        $html = "<p>".$log."<br> Card Declined</p>";
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
                        $email->setSubject("URGENT! Error Update User Regis.");
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
                    echo 'DB';
                }
            }
            elseif($resType === "cancellation") {
                $row = $result->fetch_assoc();
                $transactionID = $row['transactionID'];
                $conn->autocommit(false);
                $updateTrans = $conn->query("UPDATE transactions SET confirmationDate = '$confirmation_date', cancellationDate = '$confirmation_date', cancelledBy = '$seller_ID' WHERE itemID = '$item_ID' AND sellerID = '$seller_ID' AND buyerID = '$buyer_ID' AND confirmationDate = '0000-00-00 00:00:00';");
                $deleteNotif = $conn->query("DELETE FROM notifications WHERE post_id = '$item_ID' AND user_id = '$buyer_ID' AND target_id = '$seller_ID';");
                $getBuyerInfo = $conn->query("SELECT * FROM transactions, thebag, users WHERE transactions.transactionID = '$transactionID' AND thebag.uid = transactions.buyerID AND transactions.buyerID = users.uid");

                if($updateTrans && $deleteNotif && $getBuyerInfo) {
                    $info = $getBuyerInfo->fetch_assoc();
                    $conn->commit();
                    //SEND EMAIL TO BUYER
                    $email = new Email($info['username'], $info['email'], 'orders@nxtdrop.com', 'Sorry, your order is cancelled', '');
                    $email->setTransactionID($transactionID);
                    $email->sendEmail('orderConfirmation');
                }
                else {
                    $conn->rollback();
                    echo 'DB';
                }
            }
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