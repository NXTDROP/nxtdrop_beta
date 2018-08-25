<?php
    function isFriend($uname) {
        include '../dbh.php';
        $follower_username = $uname;
        $user_id = $_SESSION['uid'];

        $sql = "SELECT * FROM users WHERE username='$follower_username'";
        $result = $conn->query($sql);
        $row = mysqli_fetch_assoc($result);
        $follower_id = $row['uid'];

        $query2 = "SELECT * FROM following WHERE user_id='$user_id' AND follower_id='$follower_id'";
        $result = $conn->query($query2);
        $count = mysqli_num_rows($result);
        if ($count <= 0) {
            return false;
        }
        else {
            return true;
        }
    }
?>