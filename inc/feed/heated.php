<?php
    session_start();
    include '../../dbh.php';
    date_default_timezone_set("UTC");
    $date = date("Y-m-d H:i:s", time());
    $addHeat = $conn->prepare("INSERT INTO heat (productID, userID) VALUES (?, ?);");
    $deleteCold = $conn->prepare("DELETE FROM cold WHERE productID = ? AND userID = ?");
    $productID = $_POST['productID'];
    $userID = $_SESSION['uid'];
    $conn->autocommit(false);

    if (!isset($_SESSION['uid'])) {
        die('CONNECTION');
    }
    else {
        $addHeat->bind_param("ii", $productID, $userID);
        $deleteCold->bind_param("ii", $productID, $userID);
        if($addHeat->execute() && $deleteCold->execute()) {
            $conn->commit();
            die('+1');
        } else {
            $conn->rollback();
            die('0');
        }
        
    }
?>