<?php

    session_start();
    require_once('../../../credentials.php');
    $db = '../../dbh.php';
    require_once($db);
    require_once('../currencyConversion.php');
    require_once('../../vendor/autoload.php');
    require_once('../../email/Email.php');
    $conn->autocommit(false);
    $userInfo = $conn->prepare("SELECT uid, username, email FROM users, offers WHERE users.uid = offers.sellerID AND offers.offerID = ?");
    $userInfo->bind_param('i', $offerID);

    $listItem = $conn->prepare("INSERT INTO counterOffer (offerID, userID, offer, date) VALUES (?, ?, ?, ?);");
    $listItem->bind_param("iiis", $offerID, $userID, $price, $date);

    $sendNotif = $conn->prepare("INSERT INTO notifications (post_id, user_id, target_id, notification_type, date) VALUES (?, ?, ?, ?, ?)");
    $sendNotif->bind_param("iiiss", $offerID, $userID, $targetID, $type, $date);
    date_default_timezone_set("UTC");

    $checkToken = $conn->prepare("SELECT out_token FROM thebag WHERE uid = ?");
    $checkToken->bind_param("i", $userID);

    if(!isset($_SESSION['uid'])) {
        die('CONNECTION');
    } else {
        $offerID = $_POST['offerID'];
        $userID = $_SESSION['uid'];

        if($checkToken->execute()) {
            $checkToken->bind_result($out_token);
            $checkToken->fetch();

            if($out_token == "") {
                $checkToken->close();
                $conn->rollback();
                die('CARD');
            }
            $checkToken->close();
        } else {
            $conn->rollback();
            die('DB');
        }

        if($userInfo->execute()) {
            $userInfo->bind_result($targetID, $targetU, $targetE);
            $userInfo->fetch();
            if(!isset($_POST['price'])) {
                die('MISSING');
            } else {
                if($_SESSION['country'] == 'US') {
                    $price = $_POST['price'];
                } elseif ($_SESSION['country'] == 'CA') {
                    $price = cadTousd($_POST['price'], $db, false);
                } else {
                    $price = $_POST['price'];
                }
                $userID = $_SESSION['uid'];
                $date = date("Y-m-d H:i:s", time());
                $userInfo->close();
                if($listItem->execute()) {
                    $type = 'counter-offer';
                    $listItem->close();
                    if($sendNotif->execute()) {
                        $email = new Email($targetU, $targetE, 'notifications@nxtdrop.com', $_SESSION['username'].' sent you a counter-offer! Will you take it?', '');
                        $conn->commit();
                        $email->setExt('offerID='.$offerID.'&userID='.$userID);
                        $email->sendEmail('counterOffer');
                        $conn->commit();
                        $sendNotif->close();
                        die('GOOD');
                    } else {
                        $conn->rollback();
                        die('DB');
                    }
                } else {
                    $conn->rollback();
                    die('DB');
                }
            }
        } else {
            $conn->rollback();
            die('DB');
        }
    }

?>