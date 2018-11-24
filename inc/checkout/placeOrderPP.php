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

    $item_ID = $_POST['item_ID'];
    $totalPrice = $_POST['totalPrice'];
    $shippingCost = $_POST['shippingCost'];
    $chargeID = $_POST['chargeID'];
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
        $result = $conn->query("SELECT users.uid, users.username, users.email, holidayOffers.retailPrice FROM users, holidayOffers WHERE users.uid = 2 AND holidayOffers.productID = '$item_ID'");
        $row = $result->fetch_assoc();

        $seller_ID = $row['uid'];
        $sellerEmail = $row['email'];
        $sellerUsername = $row['username'];
        $price = $row['retailPrice'];
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
        $addTransaction = $conn->query("INSERT INTO transactions (itemID, sellerID, buyerID, status, purchaseDate, totalPrice, chargeID, chargeDate) VALUES ('$item_ID', '$seller_ID', '$buyerID', '$status', '$purchaseDate', '$totalPrice', '$chargeID', '$purchaseDate');");

        //GET TRANSACTIONID JUST CREATED ABOVE
        $getTID = $conn->query("SELECT transactionID FROM transactions WHERE itemID = '$item_ID' AND sellerID = '$seller_ID' AND purchaseDate = '$purchaseDate';");
        $data = $getTID->fetch_assoc();
        $transactionID = $data['transactionID'];

        //CREATE SHIPMENT
        $addShipping = $conn->query("INSERT INTO shipping (transactionID, cost) VALUES ('$transactionID', '$shippingCost');");

        //ADD DISCOUNT IF USED
        if(isset($_POST['discountID'])) {
            $discountID = $_POST['discountID'];
            $addDiscount = $conn->query("INSERT INTO discountUsed (ID, usedBy, dateUsed, transactionID) VALUES ('$discountID', '$n_id', '$purchaseDate', '$transactionID');");
        } else {
            $addDiscount = true;
        }

        $deletePromoNotification = $conn->query("DELETE FROM notifications WHERE target_id = '$buyerID' AND notification_type = 'promo';");


        //CHECK IF DATA WAS INSERTED IN DB IF NOT ROLLBACK AND PRINT ERROR, OTHERWISE COMMIT, SEND EMAIL TO BUYER AND PRINT TID
        if($addShipping && $addTransaction && $addDiscount && $deletePromoNotification) {

            $conn->commit();

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
                die($transactionID);
            } catch (Exception $e) {
                //PRINT TID
                die($transactionID);
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