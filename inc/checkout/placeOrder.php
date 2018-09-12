<?php

    session_start();
    include '../../dbh.php';
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
        $query = "SELECT * FROM users WHERE uid = '$n_id'";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        $seller_ID = $row['uid'];

        $query = "SELECT * FROM posts WHERE uid = '$item_ID'";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();

        $buyerID = $row['uid'];
        $status = "waiting shipment";
        $conn->autocommit(false);
        $addTransaction = $conn->query("INSERT INTO transactions (itemID, sellerID, shippingAddress, buyerID, status, purchaseDate) VALUES ('$item_ID', '$seller_ID', '$fullAddress', '$buyerID', '$status', '$purchaseDate');");
        $addShipping = $conn->query("INSERT INTO shipping (transactionID) VALUES ('$transactionID');");
        if($addShipping && $addTransaction) {
            $conn->commit();
            echo $transactionID;
        }
        else {
            $conn->rollback();
            echo 'ERROR 102';
        }
    }

?>