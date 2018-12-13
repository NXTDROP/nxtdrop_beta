<?php
    
    session_start();
    require_once('../../dbh.php');
    $db = '../../dbh.php';
    require_once('../currencyConversion.php');
    date_default_timezone_set("UTC");
    $updateOffer = $conn->prepare("UPDATE offers SET price = ?, date = ? WHERE offerID = ? AND sellerID = ?");
    $updateOffer->bind_param("dsii", $price, $date, $offerID, $uid);

    if(!isset($_SESSION['uid'])) {
        die('not connected');
    } else {
        if(!isset($_POST['offerID'])) {
            die("error1");
        } else {
            if($_SESSION['country'] == 'US') {
                $price = $_POST['price'];
            } else {
                $price = cadTousd($_POST['price'], $db, false);
            }

            $offerID = $_POST['offerID'];
            $uid = $_SESSION['uid'];
            $date = date("Y-m-d H:i:s", time());
            if($updateOffer->execute()) {
                die('good');
            } else {
                die('DB');
            }
        }
    }

?>