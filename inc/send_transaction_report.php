<?php
    session_start();
    date_default_timezone_set("UTC"); 
    include '../dbh.php';
    $date = date("Y-m-d H:i:s", time());

    $buyer_username = $_POST['buyer_username'];
    $seller_rating = $_POST['seller_rating'];
    $post_id = $_POST['post_id'];
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $seller_comment = mysqli_real_escape_string($conn, $_POST['seller_comment']);

    $row = mysqli_fetch_assoc($conn->query("SELECT * FROM users WHERE username = '$buyer_username'"));
    $buyer_id = $row['uid'];

    if (!isset($_SESSION['uid'])) {
        echo 'Error. Try Later!';
    }
    else {
        $seller_id = $_SESSION['uid'];

        if ($buyer_id == '') {
            echo 'You must select a user!';
        }
        else {
            if (!mysqli_query($conn, "INSERT INTO transactions (seller_ID, buyer_ID, price, seller_ID, post_ID, seller_rating, report_date) VALUES ('$seller_id', '$buyer_id', '$price', '$seller_comment', '$post_id', '$seller_rating', '$date')")) {
                echo 'Error. Try Later!';
            }
        }
    }
?>