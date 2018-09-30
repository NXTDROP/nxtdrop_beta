<?php

    session_start();
    date_default_timezone_set("UTC");
    require_once('../../dbh.php');
    $last_activity = $conn->prepare("UPDATE users SET last_activity = ? WHERE uid = ?");
    $last_activity->bind_param('si', $date, $userID);
    
    if(isset($_SESSION['uid'])) {
        $userID = $_SESSION['uid'];
        $_SESSION['talkTimestamp'] = date("Y-m-d H:i:s", time());
        $date = $_SESSION['talkTimestamp'];
        
        $last_activity->execute();
    } else {
        $_SESSION['talkTimestamp'] = date("Y-m-d H:i:s", time());
    }

?>