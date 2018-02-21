<?php

    session_start();
    include '../dbh.php';

    if (isset($_SESSION['uid'])) {
        $sql = "UPDATE profile SET status='' WHERE uid='".$_SESSION['uid']."';";
        if (mysqli_query($conn, $sql)) {
            echo 'uploads/user.png';
        }
    }
    else {

    }

?>