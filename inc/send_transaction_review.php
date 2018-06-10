<?php
    session_start();
    date_default_timezone_set("UTC"); 
    include '../dbh.php';
    $date = date("Y-m-d H:i:s", time());

    $buyer_rating = $_POST['buyer_rating'];
    $buyer_comment = mysqli_real_escape_string($conn, $_POST['buyer_comment']);
    $seller_username = $_POST['seller_username'];
    $post_id = $_POST['post_id'];

    $row = mysqli_fetch_assoc($conn->query("SELECT * FROM users WHERE username = '$seller_username'"));
    $seller_id = $row['uid'];

    if (!isset($_SESSION['uid'])) {
        echo 'Error. Try Later!';
    }
    else {
        $buyer_id = $_SESSION['uid'];
        
        if ($buyer_rating < 0 & $buyer_rating > 5) {
            echo 'PLEASE RATE THE SELLER.';
        }
        else {
            $row = mysqli_fetch_assoc($conn->query("SELECT * FROM transactions WHERE buyer_ID = '$buyer_id' AND seller_ID = '$seller_id' AND post_ID = '$post_id'"));
            $transaction_id = $row['transaction_ID'];
            
            if (!mysqli_query($conn, "UPDATE transactions SET buyer_comment = '$buyer_comment', buyer_rating = '$buyer_id', confirmation_date = '$date' WHERE transaction_ID = '$transaction_id'")) {
                echo 'Error. Try Later.';
            }
        }
    }
?>