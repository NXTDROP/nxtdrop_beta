<?php
    session_start();
    include 'dbh.php';

    /*$query = "SELECT COUNT(pid) FROM likes WHERE pid = 1;";
    $qresult = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($qresult);
    $count = $row["COUNT(pid)"];
    echo $count;*/

    $pid = mysqli_real_escape_string($conn, $_POST['pid']);
    $posted_by = mysqli_real_escape_string($conn, $_POST['posted_by']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);

    if (isset($_SESSION['uid'])) {
        if ($type == 'like') {
            $sql = "INSERT INTO likes (pid, posted_by, liked_by) VALUES ('$pid', '$posted_by', '".$_SESSION['uid']."')";
            if (mysqli_query($conn, $sql)) {
                $query = "SELECT COUNT(pid) FROM likes WHERE pid = $pid;";
                $qresult = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($qresult);
                $count = $row["COUNT(pid)"];
                if (mysqli_query($conn, "UPDATE posts SET likes = $count WHERE pid = $pid;")) {
                    $result = array(
                        'likes' => $count,
                    );
                    echo json_encode($result);
                } else die;
            }
            else die;
        }
        else if ($type == 'unlike') {
            $sql = "DELETE FROM likes WHERE pid = $pid AND posted_by = $posted_by AND liked_by = ".$_SESSION['uid'].";";
            if (mysqli_query($conn, $sql)) {
                $query = "SELECT COUNT(pid) FROM likes WHERE pid = $pid;";
                $qresult = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($qresult);
                $count = $row["COUNT(pid)"];
                if (mysqli_query($conn, "UPDATE posts SET likes = $count WHERE pid = $pid;")) {
                    $result = array(
                        'likes' => $count,
                    );
                    echo json_encode($result);
                } else die;
            }
            else die;
        }
    }
    else {
        die;
    }
?>