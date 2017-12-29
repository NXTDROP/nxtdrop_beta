<?php
    include 'dbh.php';
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username LIKE '%".$_POST['name']."%' LIMIT 10");

    while ($r = mysqli_fetch_assoc($query)) {
        $name = "'".$r['username']."'";
        echo '<li class="user_r">'.$r['username'].'</li>';
    }
?>