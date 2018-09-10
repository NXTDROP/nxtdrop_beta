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
            if($_SESSION['uid'] != ($row['sellerID'] || $row['middlemanID'])) {
                $style = 'style="background-color: #000; color: #000;"';
                $row['first_name'] = '';
                $row['last_name'] = '';
                $row['shippingAddress'] = '';
                $country = '';
            }
            else {
                $style = '';
            }

            if($row['MM_Carrier'] != '') {
                $carrier = $row['MM_Carrier'];
                $trackingno = $row['MM_TrackingNumber'];
            }
            else {
                $carrier = 'N/A';
                $trackingno = 'N/A';
            }
        ?>

        <div class="container order">
            <h2>Order Details</h2>
            <p style="text-align: center;">Thank you for shopping with us!</p>
            <p style="text-align: center; font-weight: 800; color: tomato;">Order Status: <?php echo $row['status']; ?></p>
            <p id="order-id">Order ID: #<?php echo $row['transactionID']; ?></p>
            <p id="order-sellerInfo">Seller: <a href="profile.php?u=<?php echo $row['username']; ?>"><?php echo $row['username']; ?></a></p>
            <h3>Shipping To:</h3>
            <p id="order-buyerInfo" <?php echo $style; ?>><?php echo $row['first_name'].' '.$row['last_name']; ?> <br>
            <?php echo $row['shippingAddress'].'<br>'.$country; ?></p>
            <p style="color: tomato;">Carrier: <?php echo $carrier; ?></p>
            <p style="color: tomato;">Tracking #: <?php echo $trackingno; ?></p>
            <p id="order-shippingCost">Shipping Cost: $<?php echo number_format($row['totalPrice']-$row['product_price'], 2, '.', ','); ?></p>
            <h3>Item Details</h3>
            <img src="img/AJ1OFF.jpg"><span><?php echo $row['caption']; ?></span>
            <p id="order-itemPrice">Price: $<?php echo number_format($row['product_price'], 2, '.', ','); ?></p>
            <h2 id="order-total">Total: $<?php echo number_format($row['totalPrice'], 2, '.', ','); ?></h2>
        </div>

        <?php include('inc/drop/new-drop-pop.php'); ?>
        <?php include('inc/search_pop.php'); ?>
        <?php 
            if(isset($_GET['tracking'])) {
                include('inc/notificationPopUp/shippingPopUp.php');
            }
        ?>
    </body>
</html>