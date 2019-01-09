<?php 
    session_start();
    include "dbh.php";
    if (isset($_SESSION['uid'])) {
        date_default_timezone_set("UTC");
    }
    else {
        header("Location: signup");
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include('inc/head.php'); ?>
        <title>
            Checkout - NXTDROP - Canada's #1 Sneaker Marketplace
        </title>
        <link rel="canonical" href="https://nxtdrop.com/placeOrder.php">
        <script type="text/javascript">
            $(document).ready(function() {
                $('#load_title').html('DO NOT REFRESH...')
                $(".load").fadeIn();
                $(".load_main").show();

                var itemID = <?php echo "'".$_GET['itemID']."'"; ?>;
                var amount = <?php echo "'".$_GET['amount']."'"; ?>;
                var shippingAddress = <?php echo "'".$_GET['shippingAddress']."'"; ?>;
                var shippingCost = <?php echo "'".$_GET['shippingCost']."'"; ?>;
                <?php if($_GET['discountID'] != '') {echo 'var discountID = '.$_GET['discountID'].';';} else{echo 'var discountID;';} ?>;
                var checkout_id = <?php echo "'".$_GET['checkout_id']."'"; ?>;

                $.ajax({
                    url: 'inc/checkout/placeOrder.php',
                    type: 'POST',
                    data: {itemID: itemID, shippingAddress: shippingAddress, discountID: discountID, amount: amount, shippingCost: shippingCost, checkout_id: checkout_id},
                    success: function(data) {
                        console.log(data);
                        if(data === 'ERROR 101') {
                            $('.load_content').html('You must be logged in to purchase an item.');
                        } else if(data === 'ERROR 102') {
                            $('.load_content').html('We have a problem. Please contact support@nxtdrop.com.');
                        } else if(data === 'DB') {
                            $('.load_content').html('We have a problem. Please contact support@nxtdrop.com.');
                        } else {
                            window.location.replace('orderPlaced.php?transactionID='+data);
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        $('.load_content').html('Sorry, we could not place your order. Contact our support team @ support@nxtdrop.com.');
                    }
                });
            });
        </script>
    </head>

    <body>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-546WBVB"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        <?php include('inc/checkout/loadingInfo.php'); ?>
    </body>
</html>