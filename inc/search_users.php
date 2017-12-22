<?php
    include 'dbh.php';
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username LIKE '%".$_POST['name']."%' LIMIT 5");

    foreach($query as $key) {
?>

<div id="user"><span><?php echo $key['username']; ?></span></div>

<?php
    }
?>