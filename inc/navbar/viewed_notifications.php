<?php
    session_start();
    include '../../dbh.php';

    if (!isset($_SESSION['uid'])) {
        die;
    }
    else {
        $uid = $_SESSION['uid'];
        $sql = "SELECT notif_id FROM notifications WHERE target_id = '$uid' AND viewed = '0'";
        $result = $conn->query($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $notif_id = $row['notif_id'];
            $conn->query("UPDATE notifications SET viewed = '1' WHERE notif_id = '$notif_id'");
        }
    }
    
?>