<?php
    session_start();
    include 'dbh.php';

    $pid = mysqli_real_escape_string($conn, $_GET['pid']);
    $sql = "SELECT * FROM posts WHERE pid='$pid';";
    $result = mysqli_query($conn, $sql);
    $check = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);

    if (isset($_SESSION['uid'])) {
        if ($_SESSION['uid'] == $row['uid']) {
            $sql = "DELETE FROM posts WHERE pid= '$pid';";
            mysqli_query($conn, $sql);
            return false;
        }
        else {
            return true;
        }
    }
    else {
        return true;
    }
?>