<?php 
    session_start();
    $db = "dbh.php";
    require_once('login/rememberMe.php');
    require_once('inc/currencyConversion.php');
    include $db;
    if (isset($_SESSION['uid'])) {
        date_default_timezone_set("UTC");
    }
    else {
        header("Location: https://nxtdrop.com/");
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include('inc/head.php'); ?>
        <title>
            OrderPlaced - NXTDROP - Canada's #1 Sneaker Marketplace
        </title>
        <link rel="canonical" href="https://nxtdrop.com/orderPlaced.php" />
        <!-- Javasripts -->
        <script type="text/javascript">
            var transactionID = <?php echo "'".$_GET['transactionID']."'"; ?>;
        </script>
    </head>

    <body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-546WBVB"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<script>
    fbq('track', 'Purchase');
</script>
        <?php include('inc/navbar/navbar.php'); ?>

        <?php
            $transactionID = $_GET['transactionID'];
            if($_SESSION['country']) $country = "United States";
            elseif($_SESSION['country']) $country = "Canada";
            $query = "SELECT p.assetURL, p.model, o.price, s.cost, t.shippingAddress, s.MM_Carrier, s.MM_TrackingNumber, t.transactionID, t.totalPrice, t.sellerID, t.middlemanID, tb.first_name, tb.last_name, t.status, u.username FROM users u, transactions t, shipping s, thebag tb, offers o, products p WHERE t.transactionID = '$transactionID' AND t.transactionID = s.transactionID AND t.sellerID = u.uid AND u.uid = tb.uid AND t.itemID = o.offerID AND o.productID = p.productID";
            $result = $conn->query($query);
            $row = mysqli_fetch_assoc($result);
            if($row['transactionID'] === '') {
                header("Location: home");
            }
            if($_SESSION['uid'] == ($row['sellerID'] || $row['middlemanID'])) {
                $style = 'style="background-color: #000; color: #000;"';
                $row['first_name'] = '';
                $row['last_name'] = '';
                $row['shippingAddress'] = '';
                $country = '';
            }
            else {
                $style = '';
            }

            if($_SESSION['country'] == 'US') {
                $currency = "$";
            } else if($_SESSION['country'] == "CA") {
                $currency = "CA$";
                $row['cost'] = usdTocad($row['cost'], $db, false);
                $row['price'] = usdTocad($row['price'], $db, false);
                $row['totalPrice'] = usdTocad($row['totalPrice'], $db, false);
            } else {
                $currency = "$";
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
            <!--<p id="order-sellerInfo">Seller: <a href="profile.php?u=<?php //echo $row['username']; ?>"><?php //echo $row['username']; ?></a></p>-->
            <h3>Shipping To:</h3>
            <p id="order-buyerInfo" <?php echo $style; ?>><?php echo $row['first_name'].' '.$row['last_name']; ?> <br>
            <?php echo $row['shippingAddress'].'<br>'.$country; ?></p>
            <p style="color: tomato;">Carrier: <?php echo $carrier; ?></p>
            <p style="color: tomato;">Tracking #: <?php echo $trackingno; ?></p>
            <p id="order-shippingCost">Shipping Cost: <?php echo $currency.number_format($row['cost'], 2, '.', ','); ?></p>
            <h3>Item Details</h3>
            <img src="<?php echo $row['assetURL']; ?>"><span><?php echo $row['model']; ?></span>
            <p id="order-itemPrice">Price: <?php echo $currency.number_format($row['price'], 2, '.', ','); ?></p>
            <h2 id="order-total">Total: <?php echo $currency.number_format($row['totalPrice'], 2, '.', ','); ?></h2>
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