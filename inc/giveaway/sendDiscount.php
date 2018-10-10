<?php

    session_start();
    require_once('../../../credentials.php');
    require_once('../../dbh.php');
    require_once('../../vendor/autoload.php');
    require_once('../../email/Email.php');
    $conn->autocommit(false);
    $addCode = $conn->prepare("INSERT INTO discountCode (code, type, amount, assignedTo) VALUES (?, ?, ?, ?)");
    $addCode->bind_param('ssdi', $code, $type, $amount, $userID);

    $checkUser = $conn->prepare("SELECT COUNT(*) FROM discountCode WHERE assignedTo = ?");
    $checkUser->bind_param('i', $userID);

    function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    if(!isset($_SESSION['uid'])) {
        echo 'CONNECT';
    }
    else {
        $userID = $_SESSION['uid'];
       if($checkUser->execute()) {
            $checkUser->bind_result($count);
            $checkUser->fetch();
            if($count < 1) {
                $code = generateRandomString(7);
                $type = 'cash';
                $amount = 40.00;
                
                $checkUser->close();
                if($addCode->execute()) {
                    $conn->commit();
                    $addCode->close();
                    $email = new Email($_SESSION['username'], $_SESSION['email'], 'hello@nxtdrop.com', $_SESSION['username'].", here's your $40 off code", '');
                    $email->sendEmail('discount');
                    die('GOOD');
                } else {
                    $conn->rollback();
                    die('DB');
                }
            } else {
                die('EXIST');
            }

       } else {
            die('DB');
       }
    }
?>