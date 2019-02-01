<?php

    session_start();
    $db = '../../dbh.php';
    require_once($db);
    require_once('../currencyConversion.php');
    $conn->autocommit(false);
    $listItem = $conn->prepare("INSERT INTO offers (productID, sellerID, price, size, productCondition, date) VALUES (?, ?, ?, ?, ?, ?);");
    $listItem->bind_param("iiddss", $productID, $userID, $price, $size, $condition, $date);
    date_default_timezone_set("UTC");

    if(!isset($_SESSION['uid'])) {
        die('CONNECTION');
    } else {
        if(!isset($_POST['productID']) && !isset($_POST['price']) && !isset($_POST['size']) && !isset($_POST['condition'])) {
            die('MISSING');
        } else {
            if($_SESSION['country'] == 'US') {
                $price = $_POST['price'];
            } else {
                $price = cadTousd($_POST['price'], $db, false);
            }
            $size = $_POST['size'];
            $condition = $_POST['condition'];
            $productID = $_POST['productID'];
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