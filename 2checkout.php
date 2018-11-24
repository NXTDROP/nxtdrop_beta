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
        <link rel="canonical" href="https://nxtdrop.com/checkout.php">
        <!-- Javasripts -->
        <script type="text/javascript">
            var item_ID = <?php echo "'".$_GET['item']."'"; ?>;
            function goBack() {
                window.history.back();
            }
        </script>
        <script type="text/javascript" src="js/2checkout.js"></script>
    </head>

    <body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-546WBVB"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
        
        <?php include('inc/navbar/navbar.php'); ?>

        <div class="container checkout">
            <h1>Order Details</h1>

            <div class="checkout-item">
                <h3>Item</h3>
                <img id="item_img">
                <span id="item_description"></span>
                <p id="item_price"></p>
            </div>

            <div>
                <input type="text" name="discount" id="discount" placeholder="Discount Code">
                <button id="discount-btn">ADD PROMO CODE</button>
                <p id="discount-error"></p>
            </div>

            <div class="checkout-summary">
                <h3>Summary</h3>
                <div class="summary-shipping">
                    <strong>Shipping</strong>
                    <strong id="shipping-cost">FREE</strong>
                </div>
                
                <hr>
                <div class="summary-item">
                    <strong>Item</strong>
                    <strong id="item-cost">US$0.00</strong>
                </div>

                <hr>
                <div class="summary-discount">
                    <strong>Discount</strong>
                    <strong id="item-discount">- US$0.00</strong>
                </div>
                
                <hr>
                <div class="summary-total">
                    <strong>Total</strong>
                    <strong id="total-order">US$00.00</strong>
                </div>
                <hr>
            </div>

            <div id="paypal-button-container"></div>
            <script src="https://www.paypalobjects.com/api/checkout.js"></script>
            <script>
                // Render the PayPal button
                paypal.Button.render({
                // Set your environment
                env: 'production', // sandbox | production

                // Specify the style of the button
                style: {
                    layout: 'vertical',  // horizontal | vertical
                    size:   'medium',    // medium | large | responsive
                    shape:  'rect',      // pill | rect
                    color:  'black'       // gold | blue | silver | white | black
                },

                // Specify allowed and disallowed funding sources
                //
                // Options:
                // - paypal.FUNDING.CARD
                // - paypal.FUNDING.CREDIT
                // - paypal.FUNDING.ELV
                funding: {
                    allowed: [
                        paypal.FUNDING.CARD,
                        paypal.FUNDING.CREDIT
                    ],
                    disallowed: []
                },

                // Enable Pay Now checkout flow (optional)
                commit: true,

                // PayPal Client IDs - replace with your own
                // Create a PayPal app: https://developer.paypal.com/developer/applications/create
                client: {
                    sandbox: 'AfVudjpf1yvFL7Z3JHi7DyQZA4fM7boFL02Mq-ddkXq-yH9tDM6XwamvOsIAbUiNtpwYDEE7oLJ_h1iB',
                    production: 'AWHEmQ_9C-XeYg-PVgorL364RF7JSAZAsuV1P1N8JSq3F5IxL52T7Qwn7CxZs_1JyhYzDVO4LXkotuIa'
                },

                payment: function (data, actions) {
                    return actions.payment.create({
                        payment: {
                        transactions: [
                            {
                            amount: {
                                total: total,
                                currency: curr
                            }
                            }
                        ]
                        }
                    });
                },

                onAuthorize: function (data, actions) {
                return actions.payment.execute()
                    .then(function () {
                        placeOrderPP(data.paymentID);
                        console.log(data);
                    });
                }
                }, '#paypal-button-container');
            </script>
        </div>

        <?php require_once('inc/footer.php'); ?>

        <?php include('inc/drop/new-drop-pop.php'); ?>
        <?php include('inc/search_pop.php'); ?>
        <?php include('inc/checkout/loadingInfo.php'); ?>
    </body>
</html>