<?php

    session_start();
    include '../../dbh.php';
    include('../../../credentials.php');
    include('../../vendor/autoload.php');
    include('../../email/Email.php');
    date_default_timezone_set("UTC");
    $purchaseDate = date("Y-m-d H:i:s", time());

    $item_ID = $_POST['item_ID'];
    $fullAddress = $_POST['shippingAddress'];
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
        $result = $conn->query("SELECT posts.uid, users.username, users.email FROM posts, users WHERE posts.pid = '$item_ID' AND posts.uid = users.uid;");
        $row = $result->fetch_assoc();

        $seller_ID = $row['uid'];
        $sellerEmail = $row['email'];
        $sellerUsername = $row['username'];
        $status = "waiting shipment";

        $conn->autocommit(false);

        //CREATE TRANSACTION
        $addTransaction = $conn->query("INSERT INTO transactions (itemID, sellerID, shippingAddress, buyerID, status, purchaseDate) VALUES ('$item_ID', '$seller_ID', '$fullAddress', '$buyerID', '$status', '$purchaseDate');");

        //GET TRANSACTIONID JUST CREATED ABOVE
        $getTID = $conn->query("SELECT transactionID FROM transactions WHERE itemID = '$item_ID' AND sellerID = '$seller_ID' AND purchaseDate = '$purchaseDate';");
        $data = $getTID->fetch_assoc();
        $transactionID = $data['transactionID'];

        //CREATE SHIPMENT
        $addShipping = $conn->query("INSERT INTO shipping (transactionID) VALUES ('$transactionID');");

        //CHECK IF DATA WAS INSERTED IN DB IF NOT ROLLBACK AND PRINT ERROR, OTHERWISE COMMIT, SEND EMAIL TO BUYER AND PRINT TID
        if($addShipping && $addTransaction) {
            $conn->commit(); //commit

            //SEND EMAIL TO BUYER
            $username = $_SESSION['username'];
            $email = $_SESSION['email'];
            $email = new Email($username, $email, 'stripeusa@nxdrop.com', 'Your NXTDROP Receipt [ORDER #'.$transactionID.']', '');
            $email->sendEmail('orderPlaced');

            //SEND EMAIL TO SELLER
            $email = new Email($sellerUsername, $sellerEmail, 'stripeusa@nxdrop.com', 'Confirm order to get paid [ORDER #'.$transactionID.']', '');
            $email->sendEmail('sellerConfirmation');

            //SEND ALERT EMAIL
            $email = new \SendGrid\Mail\Mail(); 
            $email->setFrom("stripeusa@nxtdrop.com", "NXTDROP PAYMENTS");
            $email->setSubject("Transaction #".$transactionID."");
            $email->addTo('admin@nxtdrop.com', 'NXTDROP TEAM');
            $html = "<p>".$username." bought an item. Order #".$transactionID.".</p>";
            $email->addContent("text/html", $html);
            $sendgrid = new \SendGrid($SD_TEST_API_KEY);
            try {
                $sendgrid->send($email);
            } catch (Exception $e) {
                die();
            }

            //PRINT TID
            echo $transactionID;
        }
        else {
            $conn->rollback();
            echo 'ERROR 102';
        }
    }

?>