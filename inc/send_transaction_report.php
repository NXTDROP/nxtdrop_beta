<?php
    session_start();
    date_default_timezone_set("UTC"); 
    include '../dbh.php';
    $date = date("Y-m-d H:i:s", time());

    $target_id = $_POST['target_id'];
    $pricing = mysqli_real_escape_string($conn, $_POST['price']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    if (!isset($_SESSION['uid'])) {
        echo 'Error. Try Later!';
    }
    else {
        $user_id = $_SESSION['uid'];

        if ($target_id == '') {
            echo 'You must select a user!';
        }
        else {
            if (!mysqli_query($conn, "INSERT INTO transactions (user_id, target_id, price, comment) VALUES ('$user_id', '$target_id', '$price', '$comment')")) {
                echo 'Error. Try Later!';
            }
            else {
                echo 'Work';
            }
        }
    }
?>