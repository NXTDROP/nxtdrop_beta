<?php
    session_start();
    include '../../dbh.php';
    $uid = $_SESSION['uid'];
    $query = "SELECT DISTINCT u_from FROM messages WHERE u_to = '$uid';";
    $result = mysqli_query($conn, $query);

    if (!mysqli_num_rows($result) > 0) {
        echo '<p id="no_user">No User Available!</p>';
    }
    else {
        while ($row = mysqli_fetch_assoc($result)) {
            $buyer_id = $row['u_from'];
            $query_result = mysqli_fetch_assoc($conn->query("SELECT username, status FROM profile, users WHERE users.uid = '$buyer_id' AND profile.uid = '$buyer_id'"));
            $buyer_username = $query_result['username'];
            $buyer_profile_pic = $query_result['status'];
            echo '<div class="users_info" id="user-'.$buyer_username.'" onclick="select('."'".$buyer_username."'".')">
                    <img src="https://nxtdrop.com/'.$buyer_profile_pic.'" alt="User" id="user_info_img">
                    <span>'.$buyer_username.'</span>
                </div>';
        }
    }
?>