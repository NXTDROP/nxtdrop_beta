<?php
    session_start();
    date_default_timezone_set("UTC"); 
    include '../dbh.php';
    $date = date("Y-m-d H:i:s", time());

    $target_username = $_POST['target_username'];
    $user_rating = $_POST['user_rating'];
    $post_id = $_POST['post_id'];
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $user_comment = mysqli_real_escape_string($conn, $_POST['user_comment']);
    $post_type = $_POST['post_type'];

    $row = mysqli_fetch_assoc($conn->query("SELECT * FROM users WHERE username = '$target_username'"));
    $target_id = $row['uid'];

    if (!isset($_SESSION['uid'])) {
        echo 'Error. Try Later!';
    }
    else {
        if (mysqli_fetch_assoc($conn->query("SELECT * FROM transactions WHERE post_ID = '$post_id'"))->num_rows > 0) {
            echo 'You already sold this item. Report the post if there is an error.';
        }
        else {
            $user_id = $_SESSION['uid'];

            if ($buyer_id == '') {
                echo 'You must select a user!';
            }
            else {
                if (!mysqli_query($conn, "INSERT INTO transactions (user_ID, target_ID, price, user_comment, post_ID, user_rating, report_date, post_type) VALUES ('$user_id', '$target_id', '$price', '$user_comment', '$post_id', '$user_rating', '$date', '$post_type')")) {
                    echo 'Error. Try Later!';
                }
                else {
                    mysqli_query($conn, "INSERT INTO notifications (user_id, target_id, notification_type, date) VALUES ('$user_id', '$target_id', 'confirmation', '$date');");
                }
            }
        }
    }
?>