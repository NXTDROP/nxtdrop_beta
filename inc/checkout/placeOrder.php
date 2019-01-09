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

    $item_ID = $_POST['itemID'];
    $fullAddress = $_POST['shippingAddress'];
    $totalPrice = $_POST['amount'];
    $shippingCost = $_POST['shippingCost'];
    $chargeID = $_POST['checkout_id'];
    $n_id = $_SESSION['uid'];

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

        //check if the order is the result of a counter-offer
        $result = $conn->query("SELECT * FROM reviewedCO WHERE reviewedCO.offerID = '$item_ID' AND reviewedCO.userID = '$buyerID' AND reviewedCO.status = 'accepted';");

        if(mysqli_num_rows($result) > 0) {
            //CREATE TRANSACTION
            $addTransaction = $conn->query("INSERT INTO transactions (itemID, sellerID, shippingAddress, buyerID, status, purchaseDate, confirmationDate, totalPrice, chargeID, chargeDate) VALUES ('$item_ID', '$seller_ID', '$fullAddress', '$buyerID', '$status', '$purchaseDate', '$purchaseDate', '$totalPrice', '$chargeID', '$purchaseDate');");
            //CREATE NOTIFICATION
            $addNotification = $conn->query("DELETE FROM notifications WHERE post_id = '$item_ID' AND target_id = '$buyerID' AND notification_type = 'counter-offer checkout';");
        } else {
            //CREATE TRANSACTION
            $addTransaction = $conn->query("INSERT INTO transactions (itemID, sellerID, shippingAddress, buyerID, status, purchaseDate, totalPrice, chargeID, chargeDate) VALUES ('$item_ID', '$seller_ID', '$fullAddress', '$buyerID', '$status', '$purchaseDate', '$totalPrice', '$chargeID', '$purchaseDate');");
            //CREATE NOTIFICATION
            $addNotification = $conn->query("INSERT INTO notifications (post_id, user_id, target_id, notification_type, date) VALUES ('$item_ID', '$n_id', '$seller_ID', 'item sold', '$purchaseDate')");
        }

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


        //CHECK IF DATA WAS INSERTED IN DB IF NOT ROLLBACK AND PRINT ERROR, OTHERWISE COMMIT, SEND EMAIL TO BUYER AND PRINT TID
        if($addShipping && $addTransaction && $addDiscount && $addNotification) {
            $conn->commit();
            //SEND EMAIL TO BUYER
            $username = $_SESSION['username'];
            $buyerEmail = $_SESSION['email'];
            $email = new Email($username, $buyerEmail, 'payments@nxdrop.com', 'Your NXTDROP Receipt [ORDER #'.$transactionID.']', '');
            $email->setTransactionID($transactionID);
            $email->sendEmail('orderPlaced');

            //SEND EMAIL TO SELLER
            $email = new Email($sellerUsername, $sellerEmail, 'payments@nxdrop.com', 'Congratulations, your item SOLD!', '');
            $email->setTransactionID($transactionID);
            $email->sendEmail('sellerConfirmation');

            //SEND ALERT EMAIL
            $email = new \SendGrid\Mail\Mail(); 
            $email->setFrom("payments@nxtdrop.com", "NXTDROP PAYMENTS");
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