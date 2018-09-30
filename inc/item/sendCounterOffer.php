<?php

    session_start();
    require_once('../../dbh.php');
    $conn->autocommit(false);
    $listItem = $conn->prepare("INSERT INTO counterOffer (offerID, userID, offer, date) VALUES (?, ?, ?, ?);");
    $listItem->bind_param("iiis", $offerID, $userID, $price, $date);
    date_default_timezone_set("UTC");

    if(!isset($_SESSION['uid'])) {
        die('CONNECTION');
    } else {
        if(!isset($_POST['price'])) {
            die('MISSING');
        } else {
            $price = $_POST['price'];
            $offerID = $_POST['offerID'];
            $userID = $_SESSION['uid'];
            $date = date("Y-m-d H:i:s", time());
            if($listItem->execute()) {
                $conn->commit();
                die('GOOD');
            } else {
                $conn->rollback();
                die('DB');
            }
        }
    }

?>