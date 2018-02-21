<?php
    include '../dbh.php';
    $commentNewCount = $_POST['commentNewCount'];

    $sql = "SELECT * FROM posts ORDER BY p_date DESC LIMIT $commentNewCount;";
    $result = mysqli_query($conn, $sql);
    if (!mysqli_num_rows($result) > 0) {
        echo "<p>No Post Available!</p>";
    }
    else {
        while ($row = mysqli_fetch_assoc($result)) {
            $pic = $row['pic'];
            echo "<img src='$pic'><br>";
            echo "<p>";
            echo $row['caption'];
            echo "</p><br><br>";
        }
    }
?>