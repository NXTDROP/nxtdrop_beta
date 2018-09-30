<?php

    session_start();
    require_once('../../dbh.php');
    $conn->autocommit(false);
    $send = $conn->prepare("INSERT INTO preferences (userID, brand1, brand2, interest, date) VALUES (?, ?, ? ,?, ?);");
    $send->bind_param('sssss', $userID, $brand1, $brand2, $interest, $date);
    date_default_timezone_set("UTC");

    if(!isset($_SESSION['uid'])) {
        die('CONNECTION');
    } else {
        if(!isset($_POST['brand1']) || !isset($_POST['brand2']) || !isset($_POST['interest'])) {
            die('MISSING');
        } else {
            $userID = $_SESSION['uid'];
            $brand1 = $_POST['brand1'];
            $brand2 = $_POST['brand2'];
            $interest = $_POST['interest'];
            $date = date("Y-m-d H:i:s", time());
            die('GOOD');

            /*if($send->execute()) {
                $conn->commit();
                die('GOOD');
            } else {
                $conn->rollback();
                die('DB');
            }*/
        }
    }

?>