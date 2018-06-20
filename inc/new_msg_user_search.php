<?php
    include '../dbh.php';
    $user_search = mysqli_real_escape_string($conn, $_GET['name']);
    $users_query = "SELECT * FROM users, profile WHERE username LIKE '%".$user_search."%' AND users.uid = profile.uid LIMIT 10";
    $users_result = $conn->query($users_query);

    if ($user_search == '') {
        echo '<p>NO USER FOUND!</p>';
    }
    else {
        while ($row = mysqli_fetch_assoc($users_result)) {
            if ($row['status'] == '') $row['status'] = 'uploads/user.png';
            $username = "'".$row['username']."'";
            echo '<div class="one_user" id="user-'.$row['username'].'" onclick="select_user('.$username.')">
                <img src="'.$row['status'].'"><span>'.$row['username'].'</span>
                </div>';
        }
    }
?>