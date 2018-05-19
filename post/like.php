<?php
    session_start();
    include '../dbh.php';
    date_default_timezone_set("UTC");
    $date = date("Y-m-d H:i:s", time());
    $query = "SELECT COUNT(pid) FROM likes WHERE pid = $pid;";
    $qresult = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($qresult);
    $count = $row["COUNT(pid)"];

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
                    $like_query = "INSERT INTO notifications (user_id, target_id, notification_type, date) VALUES ('$liked_by', '$posted_by', 'like', '$date');";
                    mysqli_query($conn, $like_query);
                    echo $count + 1;
                } 
                else {
                    die;
                }
            } 
            else {
                echo $count;
            }
        }
        else if ($type == 'unlike') {
            $sql = "DELETE FROM likes WHERE pid = $pid AND posted_by = '$posted_by' AND liked_by = '$liked_by';";
            if (mysqli_query($conn, $sql)) {
                $like_query = "DELETE FROM notifications WHERE post_id='$pid' AND user_id='$liked_by' AND target_id='$posted_by' AND notification_type='like';";
                mysqli_query($conn, $like_query);
                echo $count - 1;
            }
            else {
             die;   
            }
        }
    }
    else {
        die;
    }
?>