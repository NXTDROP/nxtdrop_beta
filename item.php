<?php 
    session_start();
    include "dbh.php";
    $model = $_GET['model'];
    $getItem = $conn->prepare("SELECT brand, line, model, colorway, yearMade, assetURL FROM products WHERE model = ?");
    $getItem->bind_param('s', $model);
?>
<!DOCTYPE html>
<html>
    <title>
        NXTDROP: The Fashion Trade Centre
    </title>
    <head>
        <?php include('inc/head.php'); ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $.ajax({
                    url: 'inc/item/getOffers.php',
                    type: 'POST',
                    data: {model: <?php echo "'".$model."'"; ?>},
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
        </script>
    </head>

    <body>
        <?php include('inc/navbar/navbar.php'); ?>
        
        <?php
            $getItem->execute();
            $getItem->bind_result($brand, $line, $model, $colorway, $yearMade, $assetURL);
            $getItem->fetch();
        ?>
        <div class="item_container">
            <div class="item_description">
                <img src="<?php echo $assetURL; ?>" alt="<?php echo $model; ?>" class="asset">
                <p class="product_name"><?php echo $brand.', '.$line.', '.$model; ?></p>
                <p>Colorway: <span class="colorway"><?php echo $colorway; ?></span></p>
                <p>Release Date: <span class="date"><?php echo $yearMade; ?></span></p>
            </div>

            <div class="item_offers">
                <p style="text-align: center; font-size: 2em; margin-top: 40%;">
                    <i class="fas fa-circle-notch fa-spin"></i>
                </p>
            </div>
        </div>

        <?php include('inc/talk/popup.php') ?>
        <?php //include('inc/drop/new-drop-pop.php'); ?>
        <?php include('inc/new-msg-post.php'); ?>
        <?php include('inc/flag-post.php'); ?>
        <?php include('inc/invite/popup.php'); ?>
        <?php include('inc/sold_pop.php') ?>
        <?php include('inc/search_pop.php') ?>
        <?php include('inc/buyer_transaction_confirmation.php') ?>
        <?php include('inc/notificationPopUp/sellerConfirmation.php') ?>
        <?php include('inc/notificationPopUp/MM_verification.php') ?>
        <?php //include('inc/giveaway/popUp.php') ?>

        <p id="message"></p>

    </body>
</html>