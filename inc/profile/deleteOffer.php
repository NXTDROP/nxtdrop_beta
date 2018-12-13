<?php
    
    session_start();
    require_once('../../dbh.php');
    $db = '../../dbh.php';
    $updateOffer = $conn->prepare("DELETE FROM offers WHERE offerID = ? AND sellerID = ?");
    $updateOffer->bind_param("ii", $offerID, $uid);

    if(!isset($_SESSION['uid'])) {
        die('not connected');
    } else {
        if(!isset($_POST['offerID'])) {
            die("error1");
        } else {
            $offerID = $_POST['offerID'];
            $uid = $_SESSION['uid'];
            if($updateOffer->execute()) {
                die('good');
            } else {
                die('DB');
            }
        }
    }

?>