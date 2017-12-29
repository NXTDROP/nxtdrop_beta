<?php
    include 'dbh.php';
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username LIKE '%".$_POST['name']."%' LIMIT 10");

    while ($r = mysqli_fetch_assoc($query)) {
        $uid = $r['uid'];
        $result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM profile WHERE uid = $uid"));
        if ($result['status'] == '') {
            $result['status'] = 'uploads/user.png';
        }
        $name = "'".$r['username']."'";
        echo '<li class="user_r"><span><img src="'.$result['status'].'" height="10px"/></span>'.$r['username'].'</li>';
    }
?>