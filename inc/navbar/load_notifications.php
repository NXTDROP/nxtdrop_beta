<?php
    session_start();
    include '../../dbh.php';
    include '../time.php';

    if (!isset($_SESSION['uid'])) {
        echo 'ERROR!';
    }
    else {
        $uid = $_SESSION['uid'];
        $sql = "SELECT * FROM notifications WHERE target_id = '$uid' ORDER BY date DESC LIMIT 15";
        $result = $conn->query($sql);

        if (!mysqli_num_rows($result) > 0) {
            echo '<p>You have 0 notifications.</p>';
        }
        else {
            while($row = mysqli_fetch_assoc($result)) {
                $post_id = "'".$row['post_id']."'";
                $uid = $row['user_id'];


                if ($row['post_id'] == '0') {
                    $sql = "SELECT * FROM users, profile WHERE users.uid = '$uid' AND profile.uid = '$uid'";
                }
                else {
                    $sql = "SELECT * FROM posts, users, profile WHERE posts.pid = $post_id AND users.uid = posts.uid AND users.uid = profile.uid";
                }

                $r = $conn->query($sql);
                $user_result = mysqli_fetch_assoc($r);

                $date = getPostTime($row['date']);

                if ($user_result['status'] == '') {
                    $user_result['status'] = "uploads/user.png";
                }

                if ($row['viewed'] == 0) {
                    $background = 'style="background:#ffc1c1"';
                }
                else {
                    $background = '';
                }
    
                if ($row['notification_type'] == 'like') {
                    echo '<div class="one_notif" onclick="go_to_post('.$post_id.')" '.$background.'><img src="'.$user_result['status'].'" alt="" class="profile_notif"><span class="message_notif"><a href="profile.php?u='.$user_result['username'].'" id="notif_user">'.$user_result['username'].'</a> liked your post. <span class="notif_time">'.$date.'</span></span><img src="'.$user_result['pic'].'" alt="" class="post_img"></div>';
                }
                else if ($row['notification_type'] == 'follow') {
                    $username = "'".$user_result['username']."'";
                    echo '<div class="one_notif" onclick="go_to_profile('.$username.')" '.$background.'><img src="'.$user_result['status'].'" alt="" class="profile_notif"><span class="message_notif"><a href="profile.php?u='.$user_result['username'].'" id="notif_user">'.$user_result['username'].'</a> is now following you. <span class="notif_time">'.$date.'</span></span></div>';
                }
                else {
                    echo '<div class="one_notif" onclick="go_to_post('.$post_id.')" '.$background.'><img src="'.$user_result['status'].'" alt="" class="profile_notif"><span class="message_notif"><a href="profile.php?u='.$user_result['username'].'" id="notif_user">'.$user_result['username'].'</a> made you an offer. <span class="notif_time">'.$date.'</span></span><img src="'.$user_result['pic'].'" alt="" class="post_img"></div>';
                }
            }
        }
    }
?>