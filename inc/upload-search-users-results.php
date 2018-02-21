<?php
        include '../dbh.php';
        if(isset($_POST['numData'])) {
            $numData = $_POST['numData'];
            $query = mysqli_query($conn, "SELECT * FROM users WHERE username LIKE '%".$_POST['q']."%' LIMIT $numData");
        }
        else {
            $numData = 5;
            $query = mysqli_query($conn, "SELECT * FROM users WHERE username LIKE '%".$_GET['q']."%' LIMIT $numData");
        }

        while ($r = mysqli_fetch_assoc($query)) {
            $uid = $r['uid'];
            $result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM profile WHERE uid = $uid"));
            if ($result['status'] == '') {
                $result['status'] = 'uploads/user.png';
            }
            $name = "'".$r['username']."'";
            echo '<a href="u/'.$r['username'].'"><div class="user_result"><img style="object-fit: cover; z-index: 0;" src="'.$result['status'].'"/><span>@'.$r['username'].'</span></div></a><hr/>';
        }
    ?>