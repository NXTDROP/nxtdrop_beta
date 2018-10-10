<?php

    function convertAt($str) {
        $regex = "/@+([a-zA-Z0-9_\.\-]+)\b/";
        $str = preg_replace($regex, '<a class="talk_at" href="u/$1">$0</a>', $str);

        if(preg_match($regex, $str, $matches)) {
            $u = $matches[1];
        } else {
            $u = '';
        }

        $arr = array($str, $u);
        
        return $arr;
    }

    /*function sendNotif($str) {
        $regex2 = "/@+([a-zA-Z0-9_\.]+)/";
        if(preg_match($regex2, $str, $matches)) {
            $addNotif = $conn->prepare("INSERT INTO notifications (user_id, target_id, notification_type, date) VALUES (?, ?, ?, ?);");
            $getUser = $conn->prepare("SELECT uid FROM users WHERE username = ?");
            $getUser->bind_param("s", $matches[1]);
            $addNotif->bind_param('iiss', $userid, $targetid, $type, $date);
            if($getUser->execute()) {
                $getUser->bind_result($targetid);
                $getUser->fetch();
                $userid = $_SESSION['uid'];
                $type = 'mentioned';
                $date = date("Y-m-d H:i:s", time());
                
                if(!$addNotif->execute()) {
                    sendNotif($str);
                } else {
                    $addNotif->close();
                    $getUser->close();
                }
            } else {
                sendNotif($str);
            }
        }
    }*/

?>