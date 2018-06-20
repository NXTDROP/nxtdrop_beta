<?php
    session_start();
    include '../../dbh.php';

    if (!isset($_SESSION['uid'])) {
        echo false;
    }
    else {
        $uid = $_SESSION['uid'];
        $sql = "SELECT * FROM notifications WHERE target_id = '$uid' AND viewed = '0'";
        $result = $conn->query($sql);
        if (mysqli_num_rows($result) > 0) {echo true;}
        else {echo false;}
    }
    
?>