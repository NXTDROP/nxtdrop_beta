<?php
    include '../../dbh.php';
    date_default_timezone_set("UTC");
    require_once('../../../credentials.php');
    require_once('../../vendor/autoload.php');
    require_once('../../email/Email.php');
    $getUserInfo = $conn->prepare("SELECT uid FROM users WHERE email = ?");
    $getUserInfo->bind_param('s', $userEmail);
    $addInvite = $conn->prepare("INSERT INTO invites (user_id, invite_email, invite_email2, date) VALUES (?, ?, ?, ?);");
    $addInvite->bind_param('isss', $uid, $friendOne, $friendTwo, $date);

    if(!isset($_POST['email'])) {
        die('ERROR');
    } else {
        if(!isset($_POST['friend_One'])) {
            die('ERROR');
        } else {
            $friendOne = $_POST['friend_One'];
            $friendTwo = $_POST['friend_Two'];
            $userEmail = $_POST['email'];
            $date = date("Y-m-d H:i:s", time());
            
            if($getUserInfo->execute()) {
                $getUserInfo->bind_result($uid);
                if($getUserInfo->fetch()) {
                    $getUserInfo->close();
                    if($addInvite->execute()) {
                        die('GOOD');

                        //SEND EMAIL TO INVITEE
                        $email = new Email();

                        if($friendTwo != '') {
                            $email = new Email();
                        }
                    }
                } else {
                    die('NOT USER');
                }
            } else {    
                die('DB');
            }
        }
    }

?>