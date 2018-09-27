<?php
    session_start();
    include '../../dbh.php';
    date_default_timezone_set("UTC");
    $date = date("Y-m-d H:i:s", time());
    $addCold = $conn->prepare("INSERT INTO cold (productID, userID) VALUES (?, ?)");
    $deleteHeat = $conn->prepare("DELETE FROM heat WHERE productID = ? AND userID = ?");
    $productID = $_POST['productID'];
    $userID = $_SESSION['uid'];
    $conn->autocommit(false);

    if (!isset($_SESSION['uid'])) {
        die('CONNECTION');
    }
    else {
        $addCold->bind_param("ii", $productID, $userID);
        $deleteHeat->bind_param("ii", $productID, $userID);
        if($addCold->execute() && $deleteHeat->execute()) {
            $conn->commit();
            die('+1');
        } else {
            $conn->rollback();
            die('0');
        }
    }
?>