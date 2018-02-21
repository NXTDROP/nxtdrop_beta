<?php
    include '../dbh.php';
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username LIKE '%".$_POST['name']."%' LIMIT 10");
    while ($r = mysqli_fetch_assoc($query)) {
        $uid = $r['uid'];
        $result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM profile WHERE uid = $uid"));
        if ($result['status'] == '') {
            $result['status'] = 'uploads/user.png';
        }
        $name = "'".$r['username']."'";
        echo '<div class="user_r"><a href="u/'.$r['username'].'"><img style="object-fit: cover; z-index: 0;" src="'.$result['status'].'">@'.$r['username'].'</a></div>';
    }
?>