<?php
    session_start();
    include '../../dbh.php';
    include '../time.php';

    if (!isset($_SESSION['uid'])) {
        echo 'ERROR!';
    }
    else {
        $uid = $_SESSION['uid'];
        $sql = "SELECT * FROM notifications WHERE target_id = '$uid' OR middleman_id = '$uid' ORDER BY date DESC LIMIT 15";
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
                elseif($row['notification_type'] === "middleman verification") {
                    $sql = "SELECT * FROM posts, transactions WHERE posts.pid = $post_id AND transactions.itemID = posts.pid";
                }
                else {
                    $sql = "SELECT * FROM posts, users, profile WHERE posts.pid = $post_id AND profile.uid = $uid AND users.uid = $uid";
                }

                $r = $conn->query($sql);
                $user_result = mysqli_fetch_assoc($r);

                $date = getPostTime($row['date']);

                if (isset($user_result['status']) && $user_result['status'] == '') {
                    $user_result['status'] = "uploads/user.png";
                }

                if ($row['viewed'] == 0) {
                    $background = 'style="background:#ffc1c1"';
                }
                else {
                    $background = '';
                }
    
                if($row['notification_type'] == 'like') {
                    echo '<div class="one_notif" onclick="go_to_post('.$post_id.')" '.$background.'><img src="'.$user_result['status'].'" alt="" class="profile_notif"><span class="message_notif"><a href="u/'.$user_result['username'].'" id="notif_user">'.$user_result['username'].'</a> liked your post. <span class="notif_time">'.$date.'</span></span><img src="'.$user_result['pic'].'" alt="" class="post_img"></div>';
                }
                else if($row['notification_type'] == 'follow') {
                    $username = "'".$user_result['username']."'";
                    echo '<div class="one_notif" onclick="go_to_profile('.$username.')" '.$background.'><img src="'.$user_result['status'].'" alt="" class="profile_notif"><span class="message_notif"><a href="u/'.$user_result['username'].'" id="notif_user">'.$user_result['username'].'</a> is now following you. <span class="notif_time">'.$date.'</span></span></div>';
                }
                else if($row['notification_type'] == 'confirmation') {
                    $username = "'".$user_result['username']."'";
                    echo '<div class="one_notif" onclick="confirmation('.$user_result['uid'].', '.$_SESSION['uid'].', '.$user_result['pid'].')" '.$background.'><img src="'.$user_result['status'].'" alt="" class="profile_notif"><span class="message_notif"><a href="u/'.$user_result['username'].'" id="notif_user">'.$user_result['username'].'</a> sold you an item. <span class="notif_time">'.$date.'</span></span></div>';
                }
                else if($row['notification_type'] == 'item sold') {
                    $pic = "'".$user_result['pic']."'";
                    $description = "'".$user_result['caption']."'";
                    $buyer_id = "'".$user_result['uid']."'";
                    echo '<div class="one_notif" onclick="order_confirmation('.$user_result['pid'].', '.$pic.', '.$description.', '.$buyer_id.')" '.$background.'><img src="https://nxtdrop.com/'.$user_result['status'].'" alt="" class="profile_notif"><span class="message_notif"><a href="u/'.$user_result['username'].'" id="notif_user">'.$user_result['username'].'</a> bought your item. Click to confirm sale. <span class="notif_time">'.$date.'</span></span><img src="'.$user_result['pic'].'" alt="" class="post_img"></div>';
                }
                else if($row['notification_type'] == 'middleman verification') {
                    $pic = "'".$user_result['pic']."'";
                    $description = "'".$user_result['caption']."'";
                    $buyer_id = "'".$user_result['buyerID']."'";
                    echo '<div class="one_notif" onclick="order_verification('.$user_result['pid'].', '.$pic.', '.$description.', '.$buyer_id.')" '.$background.'><span class="message_notif">&nbsp Item waiting for authentication. Click to send verification report. <span class="notif_time">'.$date.'</span></span><img src="'.$user_result['pic'].'" alt="" class="post_img"></div>';
                }
                else {
                    echo '<div class="one_notif" onclick="go_to_inbox()" '.$background.'><img src="'.$user_result['status'].'" alt="" class="profile_notif"><span class="message_notif"><a href="u/'.$user_result['username'].'" id="notif_user">'.$user_result['username'].'</a> made you an offer. <span class="notif_time">'.$date.'</span></span><img src="'.$user_result['pic'].'" alt="" class="post_img"></div>';
                }
            }
        }
    }
?>