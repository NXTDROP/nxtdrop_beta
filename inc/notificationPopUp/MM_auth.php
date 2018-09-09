<?php

    session_start();

    if(!isset($_SESSION['uid'])) {
        echo 'CONNECT';
    }
    else {
        include '../../dbh.php';
        date_default_timezone_set("UTC");
        $comment = $conn->real_escape_string($_POST['comment']);
        $item_ID = $conn->real_escape_string($_POST['item_ID']);
        $buyer_ID = $conn->real_escape_string($_POST['buyer_ID']);
        $condition = $conn->real_escape_string($_POST['itemCondition']);
        $MM_ID = $_SESSION['uid'];

        $query = "SELECT * FROM transactions WHERE itemID = '$item_ID' AND middlemanID = '$MM_ID' AND buyerID = '$buyer_ID' AND verificationDate = '0000-00-00 00:00:00'";
        $result = $conn->query($query);
        if(mysqli_num_rows($result) < 1) {
            echo 'VERIFIED';
        }
        else {
            if($condition === "OG") {
                $verificationDate = date("Y-m-d H:i:s", time());
                $conn->autocommit(false);
                $updateTrans = $conn->query("UPDATE transactions SET verificationDate = '$verificationDate', status = 'verified' WHERE itemID = '$item_ID' AND middlemanID = '$MM_ID' AND buyerID = '$buyer_ID'");
                $deleteNotif = $conn->query("DELETE FROM notifications WHERE post_id = '$item_ID' AND user_id = '0' AND target_id = '0' AND middleman_id = '$MM_ID';");

                if($updateTrans && $deleteNotif) {
                    $conn->commit();
                }
                else {
                    $conn->rollback();
                    echo 'DB';
                }
            }
            elseif($condition === "FAKE") {
                $verificationDate = date("Y-m-d H:i:s", time());
                $conn->autocommit(false);
                $updateTrans = $conn->query("UPDATE transactions SET verificationDate = '$verificationDate', cancellationDate = '$verificationDate', cancelledBy = '$MM_ID' WHERE itemID = '$item_ID' AND buyerID = '$buyer_ID' AND verificationDate = '0000-00-00 00:00:00';");
                $deleteNotif = $conn->query("DELETE FROM notifications WHERE post_id = '$item_ID' AND user_id = '0' AND target_id = '0' AND middleman_id = '$MM_ID';");

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