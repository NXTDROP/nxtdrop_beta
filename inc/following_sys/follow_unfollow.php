<?php
    session_start();
    date_default_timezone_set("UTC"); 
    include '../../dbh.php';
    $date = date("Y-m-d H:i:s", time());

    if (!isset($_SESSION['uid'])) {
        echo 'Error.';
    }
    else {
        $type = mysqli_real_escape_string($conn, $_POST['type']);
        $follower_username = $_POST['follower_username'];
        $user_id = $_SESSION['uid'];

        $sql = "SELECT * FROM users WHERE username='$follower_username'";
        $result = $conn->query($sql);
        $row = mysqli_fetch_assoc($result);
        $follower_id = $row['uid'];

        if ($type == 'follow') {
            $sql = "INSERT INTO following (user_id, follower_id, stamp) VALUES ('$user_id', '$follower_id', '$date')";

            if ($conn->query($sql)) {
                echo '';
                $sql = "SELECT * FROM following WHERE user_id='$user_id'";
                $sql2 = "SELECT * FROM following WHERE follower_id='$follower_id'";
                $result = $conn->query($sql);
                $result2 = $conn->query($sql2);
                $following = mysqli_num_rows($result);
                $followers = mysqli_num_rows($result2);
                $conn->query("UPDATE profile SET following='$following' WHERE uid='$user_id'");
                $conn->query("UPDATE profile SET followers='$followers' WHERE uid='$follower_id'");
                $follow_query = "INSERT INTO notifications (user_id, target_id, notification_type, date) VALUES ('$user_id', '$follower_id', 'follow', '$date');";
                mysqli_query($conn, $follow_query);
            }
            else {
                echo 'Error. Try Later!';
            }
        }
        else if ($type == 'unfollow') {
            $sql = "DELETE FROM following WHERE user_id='$user_id' AND follower_id='$follower_id'";

            if ($conn->query($sql)) {
                echo '';
                $sql = "SELECT * FROM following WHERE user_id='$user_id'";
                $sql2 = "SELECT * FROM following WHERE follower_id='$follower_id'";
                $result = $conn->query($sql);
                $result2 = $conn->query($sql2);
                $following = mysqli_num_rows($result);
                $followers = mysqli_num_rows($result2);
                $conn->query("UPDATE profile SET following='$following' WHERE uid='$user_id'");
                $conn->query("UPDATE profile SET followers='$followers' WHERE uid='$follower_id'");
                $follow_query = "DELETE FROM notifications WHERE user_id='$user_id' AND follower_id='$follower_id';";
                mysqli_query($conn, $follow_query);
            }
            else {
                echo 'Error. Try Later!';
            }
        }
        else {
            echo 'Error. Try Later!';
        }
    }
?>