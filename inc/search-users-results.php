<div class="container-users">
    <h2>People</h2>
    <?php
        include 'dbh.php';
        $query = mysqli_query($conn, "SELECT * FROM users WHERE username LIKE '%".$_GET['q']."%' LIMIT 10");

        while ($r = mysqli_fetch_assoc($query)) {
            $uid = $r['uid'];
            $result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM profile WHERE uid = $uid"));
            if ($result['status'] == '') {
                $result['status'] = 'uploads/user.png';
            }
            $name = "'".$r['username']."'";
            echo '<a href="profile.php?u='.$r['username'].'"><li class="user_r"><span><img src="'.$result['status'].'" height="10px"/></span>'.$r['username'].'</li></a>';
        }
    ?>
</div>