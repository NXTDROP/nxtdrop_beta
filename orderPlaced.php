<?php 
    session_start();
    include "dbh.php";
    if (isset($_SESSION['uid'])) {
        date_default_timezone_set("UTC");
    }
    else {
        header("Location: welcome");
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <title>
        NXTDROP: The Fashion Trade Centre
    </title>
    <head>
        <?php include('inc/head.php'); ?>
        <!-- Javasripts -->
        <script type="text/javascript">
            var item_ID = <?php echo "'".$_GET['item']."'"; ?>;
        </script>
    </head>

    <body>
        <script>
            window.fbAsyncInit = function() {
                FB.init({
                appId      : '{your-app-id}',
                cookie     : true,
                xfbml      : true,
                version    : '{api-version}'
                });
                
                FB.AppEvents.logPageView();   
                
            };

            (function(d, s, id){
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement(s); js.id = id;
                js.src = "https://connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        <?php include('inc/navbar/navbar.php'); ?>

        <?php
            $itemID = $_GET['item'];
            if($_SESSION['country']) $country = "United States";
            elseif($_SESSION['country']) $country = "Canada";
            $query = "SELECT * FROM users, transactions, shipping, thebag, posts WHERE transactions.itemID = '$itemID' AND transactions.transactionID = shipping.transactionID AND transactions.sellerID = users.uid AND users.uid = thebag.uid AND transactions.itemID = posts.pid";
            $result = $conn->query($query);
            $row = mysqli_fetch_assoc($result);
            if($row['transactionID'] === '') {
                header("Location: home");
            }
        ?>

        <div class="container order">
            <h2>Order Details</h2>
            <p style="text-align: center;">Thank you for shopping with us!</p>
            <p style="text-align: center; font-weight: 800; color: red;">Order Status: <?php echo $row['status']; ?></p>
            <p id="order-id">Order ID: #<?php echo $row['transactionID']; ?></p>
            <p id="order-sellerInfo">Seller: <a href="profile.php?u=<?php echo $row['username']; ?>"><?php echo $row['username']; ?></a></p>
            <h3>Shipping Details:</h3>
            <p id="order-buyerInfo"><?php echo $row['first_name'].' '.$row['last_name']; ?> <br>
            <?php echo $row['shippingAddress'].'<br>'.$country; ?></p>
            <p id="order-shippingCost">Shipping Cost: $<?php echo number_format($row['totalPrice']-$row['product_price'], 2, '.', ','); ?></p>
            <h3>Item Details</h3>
            <img src="img/AJ1OFF.jpg"><span><?php echo $row['caption']; ?></span>
            <p id="order-itemPrice">Price: $<?php echo number_format($row['product_price'], 2, '.', ','); ?></p>
            <h2 id="order-total">Total: $<?php echo number_format($row['totalPrice'], 2, '.', ','); ?></h2>
        </div>

        <?php include('inc/drop/new-drop-pop.php'); ?>
        <?php include('inc/search_pop.php'); ?>
    </body>
</html>