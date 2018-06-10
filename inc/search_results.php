<?php
    include '../dbh.php';
    $search = mysqli_real_escape_string($conn, $_GET['search']);

    $users_query = "SELECT * FROM users, profile WHERE username LIKE '%".$search."%' AND users.uid = profile.uid LIMIT 10";
    $users_result = $conn->query($users_query);

    if ($search == '') {
        echo '<p>NO RESULTS!</p>';
    }
    else {
        while ($row = mysqli_fetch_assoc($users_result)) {
            if ($row['status'] == '') $row['status'] = 'uploads/user.png';
            echo '<a href="https://nxtdrop.com/u/'.$row['username'].'" class="user_display">
                        <img src="https://nxtdrop.com/'.$row['status'].'">
                        <span>'.$row['username'].'</span>
                    </a>';
        }
    }
?>