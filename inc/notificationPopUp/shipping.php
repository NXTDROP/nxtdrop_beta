<?php

    session_start();

    if(!isset($_SESSION['uid'])) {
        echo 'CONNECT';
    }
    else {
        include '../../dbh.php';
        date_default_timezone_set("UTC");
        $carrier = $conn->real_escape_string($_POST['carrier']);
        $transaction_ID = $conn->real_escape_string($_POST['transaction_ID']);
        $trackingNumber = $conn->real_escape_string($_POST['trackingNumber']);
        $ID = $_SESSION['uid'];

        $query = "SELECT * FROM transactions, shipping WHERE transactions.transactionID = '$transaction_ID' AND transactions.transactionID = shipping.transactionID AND shipping.MM_TrackingNumber != ''";
        $result = $conn->query($query);
        if(mysqli_num_rows($result) > 0) {
            echo 'TRACKED';
        }
        else {
            $query = "SELECT * FROM transactions, shipping WHERE transactions.transactionID = '$transaction_ID' AND transactions.transactionID = shipping.transactionID AND shipping.MM_TrackingNumber = ''";
            $result = $conn->query($query);
            $row = $result->fetch_assoc();
            if($row['middlemanID'] === $ID) {
                $conn->autocommit(false);
                $item_ID = $row['itemID'];
                $updateShipping = $conn->query("UPDATE shipping SET MM_Carrier = '$carrier', MM_TrackingNumber = '$trackingNumber' WHERE transactionID = '$transaction_ID'");
                $deleteNotif = $conn->query("DELETE FROM notifications WHERE post_id = '$item_ID' AND user_id = '0' AND target_id = '0' AND middleman_id = '$ID';");

                if($updateShipping && $deleteNotif) {
                    $conn->commit();
                }
                else {
                    $conn->rollback();
                    echo 'DB';
                }
            }
            elseif($row['sellerID'] === $ID) {
                $conn->autocommit(false);
                $item_ID = $row['itemID'];
                $updateShipping = $conn->query("UPDATE shipping SET seller_Carrier = '$carrier', seller_TrackingNumber = '$trackingNumber' WHERE transactionID = '$transaction_ID'");
                $deleteNotif = $conn->query("DELETE FROM notifications WHERE post_id = '$item_ID' AND user_id = '0' AND target_id = '$ID' AND middleman_id = '0';");

                if($updateShipping && $deleteNotif) {
                    $buyerID = $row['buyerID'];
                    $buyerInfo = $conn->query("SELECT username, email FROM users WHERE uid = '$buyerID'");
                    $info = $buyerID->fetch_assoc();
                    $conn->commit();
                    //SEND EMAIL TO BUYER
                    $email = new Email($info['username'], $info['email'], 'orders@nxtdrop.com', 'ORDER SHIPPED!', '');
                    $email->setTransactionID($transaction_ID);
                    $email->sendEmail('orderShipping');
                }
                else {
                    $conn->rollback();
                    echo 'DB';
                }
            } else {
                echo 'ERROR';
            }
        }
    }
?>