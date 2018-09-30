<?php

    session_start();
    date_default_timezone_set("UTC"); 
    require_once('../../dbh.php');

    if(isset($_SESSION['uid'])) {
        $userID = $_SESSION['uid'];
        if(isset($_SESSION['talkTimestamp'])) {
            $checkTalk = $conn->prepare("SELECT COUNT(*) FROM talk WHERE date > ? AND userID != ?");
            $checkTalk->bind_param("si", $tTimestamp, $userID);
            $tTimestamp = $_SESSION['talkTimestamp'];
        } else {
            $getLastActivity = $conn->prepare("SELECT last_activity FROM users WHERE uid != ?");
            $getLastActivity->bind_param("i", $userID);
            $getLastActivity->execute();
            $getLastActivity->bind_result($time);
            $getLastActivity->fetch();
            $getLastActivity->close();
    
            $checkTalk = $conn->prepare("SELECT COUNT(*) FROM talk WHERE date > ?");
            $checkTalk->bind_param("s", $tTimestamp);
            $tTimestamp = $time;
        }
    
        if($checkTalk->execute()) {
            $checkTalk->bind_result($count);
            $checkTalk->fetch();
            $json = array();
    
            $data = array(
                'count' => $count,
                'timestamp' => $tTimestamp
            );
                                
            array_push($json, $data);
    
            $jsonstring = json_encode($json);
            echo $jsonstring;
        }
    } else {
        $checkTalk = $conn->prepare("SELECT COUNT(*) FROM talk WHERE date > ?");
        $checkTalk->bind_param("s", $tTimestamp);

        if(isset($_SESSION['talkTimestamp'])) {
            $tTimestamp = $_SESSION['talkTimestamp'];
        } else {
            $tTimestamp = '0000-00-00 00:00:00';
        }

        if($checkTalk->execute()) {
            $checkTalk->bind_result($count);
            $checkTalk->fetch();
            $json = array();
    
            $data = array(
                'count' => $count,
                'timestamp' => $tTimestamp
            );
                                
            array_push($json, $data);
    
            $jsonstring = json_encode($json);
            echo $jsonstring;
        }
    }

?>