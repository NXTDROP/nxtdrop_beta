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
                            window.location.replace('home');
                        } else if(data === 'ERROR 102') {
                            window.location.replace('home');
                        } else if(data === 'DB') {
                            window.location.replace('home');
                        } else {
                            window.location.replace('orderPlaced.php?transactionID='+data);
                        }
                    },
                    error: function(data) {
                        window.location.replace('home');
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