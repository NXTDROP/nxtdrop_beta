<?php 
    session_start();
    require('dbh.php');
    $db = 'dbh.php';
    require_once('login/rememberMe.php');
    $m = $_GET['model'];
    if(!isset($_SESSION['uid'])) {
        $_SESSION['rdURL'] = $_SERVER['REQUEST_URI'];
    }
    $getItem = $conn->prepare("SELECT brand, line, model, colorway, yearMade, assetURL FROM products WHERE productID = ?");
    $getItem->bind_param('i', $m);
    $getItem->execute();
    $getItem->bind_result($brand, $line, $model, $colorway, $yearMade, $assetURL);
    $getItem->fetch();
    $getItem->close();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include('inc/head_item.php'); ?>
        <title>
            <?php
                if(isset($_GET['model'])) {
                    echo $model.' - NXTDROP - Canada&apos;s #1 Sneaker Marketplace';
                } else {
                    echo 'NXTDROP - Canada&apos;s #1 Sneaker Marketplace';
                    $m = '';
                }
            ?>
        </title>
        <link rel="canonical" href="https://nxtdrop.com/sneakers/<?php echo $m; ?>" />
        <script type="text/javascript">
            $(document).ready(function() {
                checkTalk();
                $.ajax({
                    url: 'inc/item/getOffers.php',
                    type: 'POST',
                    data: {model: <?php echo "'".$m."'"; ?>},
                    success: function(response) {
                        if(response === 'DB') {
                            alert('Network problems. Sorry, try later.');
                        } else if(response === 'CONNECTION') {
                            $('.item_offers').html('<p style="text-align: center; font-size: 16px;">Log in or Sign up to see offers.</p>');
                        } else if(response === 'NOTFOUND') {
                            $('.item_offers').html('<p style="text-align: center; font-size: 16px;">Offers not found.</p>');
                        } else if(response === '') {
                            $('.item_offers').html('<p style="text-align: center; font-size: 16px;">Sold Out!</p>');
                        }else {
                            $('.item_offers').html(response);
                        }
                        
                    },
                    error: function(response) {
                        console.log(response);
                        alert("Cannot load offers. Try later.");
                    }
                });
            });

            function go_to_sell(model) {
                window.location.href = 'sell/' + model;
            }

            function checkout(id) {
                window.location.href = 'checkout.php?item=' + id;
            }

            function counter(id, price) {
                $('.transaction_pop').fadeIn();
                $('.transaction_main').show();
                cOfferID = id;
                iprice = price;
            }

            function checkTalk() {
                $.ajax({
                    url: 'inc/talk/checkTalk.php',
                    type: 'POST',
                    success: function(response) {
                        console.log(response);
                        if(jsonObject = JSON.parse(response)) {
                            var count = jsonObject[0]['count'];
                            if(count > 0) {
                                console.log(jsonObject[0]['timestamp']);
                                $('.talk-header > h2').html(count + ' New messages (tap to see)');
                                $('.talk-popup').addClass('glow');
                                setTimeout(() => {  
                                    checkTalk();
                                }, 10000);
                            } else {
                                $('.talk-header > h2').html('NXTDROP CHAT');
                                $('.talk-popup').removeClass('glow');
                                setTimeout(() => {  
                                    checkTalk();
                                }, 10000);
                            }
                        } else {
                            setTimeout(() => {  
                                checkTalk();
                            }, 5000);
                        }
                    },
                    error: function(response) {
                        setTimeout(() => {  
                            checkTalk();
                        }, 5000);
                    }   
                });
            }
        </script>
    </head>

    <body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-546WBVB"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<script>
    fbq('track', 'ViewContent');
</script>
        <?php include('inc/navbar/navbar.php'); ?>
        
        <?php
            
        ?>
        <div class="item_container">
            <div class="item_description">
                <img src="<?php echo $assetURL; ?>" alt="<?php echo $model; ?>" class="asset">
                <p class="product_name"><?php echo $brand.', '.$line.', '.$model; ?></p>
                <p>Colorway: <span class="colorway"><?php echo $colorway; ?></span></p>
                <p>Release Date: <span class="date"><?php echo $yearMade; ?></span></p>
                <button class="sell_this" onclick="go_to_sell('<?php echo $m; ?>')">Sell this item</button>
            </div>

            <div class="item_offers">
                <p style="text-align: center; font-size: 2em; margin-top: 40%;">
                    <i class="fas fa-circle-notch fa-spin"></i>
                </p>
            </div>
        </div>

        <?php require_once('inc/footer.php'); ?>
        
        <?php include('inc/item/counter_offer.php') ?>
        <?php include('inc/talk/popup.php') ?>
        <?php //include('inc/drop/new-drop-pop.php'); ?>
        <?php include('inc/search_pop.php') ?>
        <?php include('inc/buyer_transaction_confirmation.php') ?>
        <?php include('inc/notificationPopUp/sellerConfirmation.php') ?>
        <?php include('inc/notificationPopUp/MM_verification.php') ?>
        <?php //include('inc/giveaway/popUp.php') ?>

        <p id="message"></p>

    </body>
</html>