<?php
    session_start();
    include '../../dbh.php';
    include '../following_sys/functions.php';

    $username = $_POST['username'];
    $type = $_POST['display_type'];

    if (!isset($_SESSION['uid'])) {
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $uid = $row['uid'];
    } else {
        if($_SESSION['username'] === $username) {
            $uid = $_SESSION['uid'];
        } else {
            $sql = "SELECT * FROM users WHERE username='$username'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $uid = $row['uid'];
        }
    }

    if ($type == 0) {
        $sql = "SELECT * FROM following, users, profile WHERE following.follower_id = '$uid' AND following.user_id = users.uid AND following.user_id = profile.uid ORDER BY following.stamp;";
        $result = $conn->query($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            if (isFriend($row['username'])) {
                $u = "'".$row['username']."'";
                $btn = '<button id="follow_button-'.$row['username'].'" class="follow_display_button" onclick="follow_sys('.$u.')">- UNFOLLOW</button>';
            } else {
                $u = "'".$row['username']."'";
                $btn = '<button id="follow_button-'.$row['username'].'" class="follow_display_button" onclick="follow_sys('.$u.')">+ FOLLOW</button>';
            }

            if ($row['status'] == '') {
                $row['status'] = 'uploads/user.png';
            }

            echo '<div class="user_follow_display">
            <a>
                <img src="https://nxtdrop.com/'.$row['status'].'" alt="'.$row['username'].'">
                <span><a href="u/'.$row['username'].'" style="text-decoration: none; color: tomato;">'.$row['username'].'</a></span>
            </a>
            '.$btn.'
        </div>';
        }

    }
    else if ($type == 1) {
        $sql = "SELECT * FROM following, users, profile WHERE following.user_id = '$uid' AND following.follower_id = users.uid AND following.follower_id = profile.uid ORDER BY following.stamp;";
        $result = $conn->query($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['status'] == '') {
                $row['status'] = 'uploads/user.png';
            }

            $u = "'".$row['username']."'";

            echo '<div class="user_follow_display">
            <a>
                <img src="https://nxtdrop.com/'.$row['status'].'" alt="'.$row['username'].'">
                <span><a href="u/'.$row['username'].'" style="text-decoration: none; color: tomato;">'.$row['username'].'</a></span>
            </a>
            <button id="follow_button-'.$row['username'].'" class="follow_display_button" onclick="follow_sys('.$u.');">- UNFOLLOW</button>
        </div>';
        }
    }
    else {
        echo "Error. Try Later!";
    }
?>