<?php
    session_start();
    include '../../dbh.php';
    $uid = $_SESSION['uid'];
    $pid = $_POST['pid'];
    $seller_id = $_POST['seller_id'];
    $buyer_id = $_POST['buyer_id'];

    $query = "SELECT * FROM transactions, posts, users WHERE transactions.seller_ID = '$seller_id' AND transactions.buyer_ID = '$buyer_id' AND posts.pid = '$pid' AND transactions.post_ID = '$pid' AND users.uid = '$seller_id'";
    $result = $conn->query($query);
    $row = mysqli_fetch_assoc($result);
    $seller_username = $row['username'];
    $product = $row['pic'];
    

    if ($row['price'] == '') {
        $price = 'N/A';
    }
    else {
        $price = '$'.$row['price'];
    }

    echo '<p id="seller_username"><b>SELLER:</b> <span id="seller_username">'.$seller_username.'</span></p>
    <p><b>PRODUCT</b></p>
    <img id="product_image" src="https://nxtdrop.com/'.$product.'" alt="">
    <p id="product_price"><b>PRICE:</b> '.$price.'</p>';
?>  