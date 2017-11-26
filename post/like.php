<?php
    session_start();
    include 'dbh.php';

    $pid = mysqli_real_escape_string($conn, $_POST['pid']);
    $posted_by = mysqli_real_escape_string($conn, $_POST['posted_by']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);

    if (isset($_SESSION['uid'])) {
        if ($type == 'like') {
            $sql = "INSERT INTO likes (pid, posted_by, liked_by) VALUES ('$pid', '$posted_by', '".$_SESSION['uid']."')";
            if (mysqli_query($conn, $sql)) return true;
            else return false;
        }
        else if ($type == 'unlike') {
            $sql = "DELETE FROM likes WHERE pid = $pid AND posted_by = $posted_by AND liked_by = ".$_SESSION['uid'].";";
            if (mysqli_query($conn, $sql)) return true;
            else return false;
        }
    }
    else {
        return false;
    }
?>