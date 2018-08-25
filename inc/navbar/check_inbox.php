<?php
    session_start();
    include '../../dbh.php';

    if (!isset($_SESSION['uid'])) {
        echo false;
    }
    else {
        $uid = $_SESSION['uid'];
        $sql = "SELECT * FROM messages WHERE u_to = '$uid' AND opened = '0'";
        $result = $conn->query($sql);
        if (mysqli_num_rows($result) > 0) {echo true;}
        else {echo false;}
    }
    
?>