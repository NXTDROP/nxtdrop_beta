<?php
    session_start();
    date_default_timezone_set("UTC"); 
    require_once('../../../credentials.php');
    include '../../dbh.php';
    include('../../vendor/autoload.php');
    require_once('../../email/Email.php');
    $date = date("Y-m-d H:i:s", time());
    $addNotif = $conn->prepare("INSERT INTO notifications (post_id, user_id, target_id, notification_type, date) VALUES (?, ?, ?, ?, ?)");
    $addNotif->bind_param("iiiss", $tID, $uid, $tid, $type, $date);

    $getUser = $conn->prepare("SELECT users.uid, users.email, talk.talkID FROM users, talk WHERE users.username = ? AND talk.userID = ? AND talk.date = ?");
    $getUser->bind_param("sis", $username, $userid, $mdate);

    if(isset($_SESSION['uid'])) {
        $username = preg_replace('/\s+/', '', $_POST['username']);
        $mdate = $_POST['date'];
        $userid = $_SESSION['uid'];
        if($getUser->execute()) {
            $getUser->bind_result($targetid, $email, $talkID);
            if($getUser->fetch()) {
                $tid = $targetid;
                $tID = $talkID;
                $uid = $userid;
                $type = 'mentioned';
                $date = date("Y-m-d H:i:s", time());
                $target_email = $email;
                $target_username = $username;
                $user_username = $_SESSION['username'];
                
                $getUser->close();
                if($addNotif->execute()) {
                    $addNotif->close();
                    $email = new Email($target_username, $target_email, 'notifications@nxtdrop.com', $user_username.' mentioned you.', '');
                    $email->setTID($tID);
                    if($email->sendEmail('mentionNotification')) {
                        die('GOOD');
                    }
                } else {
                    die('DB1');
                }
            } else {
                die('DB2');
            }
        } else {
            die('DB3');
        }
    }

    
?>