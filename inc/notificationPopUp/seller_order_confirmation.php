<?php

    session_start();

    if(!isset($_SESSION['uid'])) {
        echo 'CONNECT';
    }
    else {
        include '../../dbh.php';
        date_default_timezone_set("UTC");
        $confirmation_date = date("Y-m-d H:i:s", time());
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
                $conn->autocommit(false);
                $updateTrans = $conn->query("UPDATE transactions SET confirmationDate = '$confirmation_date' WHERE itemID = '$item_ID' AND sellerID = '$seller_ID' AND buyerID = '$buyer_ID' AND confirmationDate = '0000-00-00 00:00:00';");
                $deleteNotif = $conn->query("DELETE FROM notifications WHERE post_id = '$item_ID' AND user_id = '$buyer_ID' AND target_id = '$seller_ID';");

                if($updateTrans && $deleteNotif) {
                    $conn->commit();
                }
                else {
                    $conn->rollback();
                    echo 'DB';
                }
            }
            elseif($resType === "cancellation") {
                $conn->autocommit(false);
                $updateTrans = $conn->query("UPDATE transactions SET confirmationDate = '$confirmation_date', cancellationDate = '$confirmation_date', cancelledBy = '$seller_ID' WHERE itemID = '$item_ID' AND sellerID = '$seller_ID' AND buyerID = '$buyer_ID' AND confirmationDate = '0000-00-00 00:00:00';");
                $deleteNotif = $conn->query("DELETE FROM notifications WHERE post_id = '$item_ID' AND user_id = '$buyer_ID' AND target_id = '$seller_ID';");

                if($updateTrans && $deleteNotif) {
                    $conn->commit();
                }
                else {
                    $conn->rollback();
                    echo 'DB';
                }
            }
        }
    }

?>