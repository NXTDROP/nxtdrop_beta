<?php
    session_start();
    include '../dbh.php';
    include '../inc/num_conversion.php';
    date_default_timezone_set("UTC");
    $date = date("Y-m-d H:i:s", time());
    $pid = $_POST['pid'];
    $query = "SELECT COUNT(pid) FROM likes WHERE pid = $pid;";
    $qresult = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($qresult);
    $count = $row["COUNT(pid)"];

    $posted_by = mysqli_real_escape_string($conn, $_POST['posted_by']);
    $liked_by = $_SESSION['uid'];
    $type = mysqli_real_escape_string($conn, $_POST['type']);

    if (isset($_SESSION['uid'])) {
        if ($type == 'like') {
            $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) FROM likes WHERE pid = '$pid' AND liked_by = '$liked_by';"));
            if ($r["COUNT(*)"] < 1) {
                if (mysqli_query($conn, "INSERT INTO likes (pid, posted_by, liked_by, time) VALUES ('$pid', '$posted_by', '$liked_by', '$date');")) {
                    if ($liked_by != $posted_by) {
                        mysqli_query($conn, "INSERT INTO notifications (user_id, target_id, notification_type, date) VALUES ('$liked_by', '$posted_by', 'like', '$date');");
                    }
                    $count++;
                    mysqli_query($conn, "UPDATE posts SET likes = '$count' WHERE pid = '$pid'");
                    echo true;
                } 
                else {
                    echo false;
                }
            } 
            else {
                echo false;
            }
        }
        else if ($type == 'unlike' && $count >= 1) {
            if (mysqli_query($conn, "DELETE FROM likes WHERE pid = $pid AND posted_by = '$posted_by' AND liked_by = '$liked_by';")) {
                if ($liked_by != $posted_by) {
                    mysqli_query($conn, "INSERT INTO notifications (post_id, user_id, target_id, notification_type, date) VALUES ('$pid', '$liked_by', '$posted_by', 'like', '$date');");
                }
                $count--;
                mysqli_query($conn, "UPDATE posts SET likes = '$count' WHERE pid = '$pid'");
                echo true;
            }
            else {
                echo false;   
            }
        }
    }
    else {
        echo false;
    }
?>