<?php
    session_start();
    include '../dbh.php';
    date_default_timezone_set("UTC");
    $date = date("Y-m-d H:i:s", time());
    /*$query = "SELECT COUNT(pid) FROM likes WHERE pid = 1;";
    $qresult = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($qresult);
    $count = $row["COUNT(pid)"];
    echo $count;*/

    $pid = mysqli_real_escape_string($conn, $_POST['pid']);
    $posted_by = mysqli_real_escape_string($conn, $_POST['posted_by']);
    $liked_by = $_SESSION['uid'];
    $type = mysqli_real_escape_string($conn, $_POST['type']);

    if (isset($_SESSION['uid'])) {
        if ($type == 'like') {
            $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) FROM likes WHERE pid = '$pid' AND liked_by = '$liked_by';"));
            if ($r["COUNT(*)"] < 1) {
                $sql = "INSERT INTO likes (pid, posted_by, liked_by, time) VALUES ('$pid', '$posted_by', '$liked_by', '$date');";
                if (mysqli_query($conn, $sql)) {
                    $query = "SELECT COUNT(pid) FROM likes WHERE pid = $pid;";
                    $qresult = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($qresult);
                    $count = $row["COUNT(pid)"];
                    if (mysqli_query($conn, "UPDATE posts SET likes = $count WHERE pid = $pid;")) {
                        echo $count;
                    } else die;
                } else die;
            } else {
                $query = "SELECT COUNT(pid) FROM likes WHERE pid = $pid;";
                $qresult = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($qresult);
                $count = $row["COUNT(pid)"];
                echo $count;
            }
        }
        else if ($type == 'unlike') {
            $sql = "DELETE FROM likes WHERE pid = $pid AND posted_by = $posted_by AND liked_by = ".$_SESSION['uid'].";";
            if (mysqli_query($conn, $sql)) {
                $query = "SELECT COUNT(pid) FROM likes WHERE pid = $pid;";
                $qresult = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($qresult);
                $count = $row["COUNT(pid)"];
                if (mysqli_query($conn, "UPDATE posts SET likes = $count WHERE pid = $pid;")) {
                    echo $count;
                } else die;
            }
            else die;
        }
    }
    else {
        die;
    }
?>