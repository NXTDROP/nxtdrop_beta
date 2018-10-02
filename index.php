<?php 
    session_start();
    include 'dbh.php';
?>
<!DOCTYPE html>
<html>
    <title>
        NXTDROP: The Fashion Trade Centre
    </title>
    <head>
        <?php include('inc/head.php'); ?>
        <!-- Javasripts -->
        <script type="text/javascript" src="js/delete-post.js"></script>
        <script type="text/javascript" src="js/like-unlike-post.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                checkTalk();

                $('.see_more').click(function() {
                    $('.see_more').html('<i class="fas fa-circle-notch fa-spin"></i>');
                    $.ajax({
                        url: 'inc/feed/getMore.php',
                        type: 'POST',
                        success: function(response) {
                            if(response != "ERROR") {
                                $(response).insertBefore('.end_item');
                                $('.see_more').html("See More");
                            }
                        }
                    });
                });
            });  

            function item(model) {
                window.location.href = 'sneakers/'+model;
            }
            
            function heat(id) {
                if(!$('#heat-'+id).hasClass('heated')) {
                    $.ajax({
                        url: 'inc/feed/heated.php',
                        type: 'POST',
                        data: {productID: id},
                        success: function(response) {
                            console.log(response);
                            if (response === "CONNECTION") {
                                alert('Please log in or sign up.');
                            } else if (response === "0") {
                                
                            } else if (response === "+1") {
                                var heat_stats = parseInt($('#heat-stats-'+id).html());
                                var cold_stats = parseInt($('#cold-stats-'+id).html());
                                
                                if(cold_stats > 0) {
                                    $('#cold-stats-'+id).html(cold_stats -= 1);
                                }

                                $('#heat-stats-'+id).html(heat_stats += 1);
                                if($('#cold-'+id).hasClass('froze')) {
                                    $('#cold-'+id).removeClass('froze');
                                    $('#cold-'+id).addClass('cold');
                                    $('#heat-'+id).removeClass('heat');
                                    $('#heat-'+id).addClass('heated');
                                } else {
                                    $('#heat-'+id).removeClass('heat');
                                    $('#heat-'+id).addClass('heated');
                                    $('#stats-'+id).removeClass('num_stats_h');
                                    $('#stats-'+id).removeClass('num_stats_v');
                                }
                            } else {
                                console.log(response);
                                alert('We have problem.');
                            }
                        },
                        error: function() {
                            alert('Connection error.');
                        }
                    });
                }
            }

            function cold(id) {
                if(!$('#cold-'+id).hasClass('froze')) {
                    $.ajax({
                        url: 'inc/feed/froze.php',
                        type: 'POST',
                        data: {productID: id},
                        success: function(response) {
                            console.log(response);
                            if (response === "CONNECTION") {
                                alert('Please log in or sign up.');
                            } else if (response === "0") {
                                    
                            } else if (response === "+1") {
                                var cold_stats = parseInt($('#cold-stats-'+id).html());
                                var heat_stats = parseInt($('#heat-stats-'+id).html());

                                if(heat_stats > 0) {
                                    $('#heat-stats-'+id).html(heat_stats -= 1);
                                }

                                $('#cold-stats-'+id).html(cold_stats += 1);
                                if($('#heat-'+id).hasClass('heated')) {
                                    $('#heat-'+id).removeClass('heated');
                                    $('#heat-'+id).addClass('heat');
                                    $('#cold-'+id).removeClass('cold');
                                    $('#cold-'+id).addClass('froze');
                                } else {
                                    $('#cold-'+id).removeClass('cold');
                                    $('#cold-'+id).addClass('froze');
                                    $('#stats-'+id).removeClass('num_stats_h');
                                    $('#stats-'+id).removeClass('num_stats_v');
                                }
                            } else {
                                alert('We have problem.');
                            }
                        },
                        error: function() {
                            alert('Connection error.');
                        }
                    });
                }
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
        <?php include('inc/navbar/navbar.php'); ?>

        <div id="item-container">
            <?php
                if(isset($_SESSION['uid'])) {
                    $getProducts = $conn->prepare("SELECT products.productID, products.model, products.assetURL, (SELECT COUNT(*) FROM heat WHERE productID = products.productID) AS heat, (SELECT COUNT(*) FROM cold WHERE productID = products.productID) AS cold, (SELECT MIN(price) FROM offers WHERE productID = products.productID) AS minPrice, (SELECT COUNT(userID) FROM heat WHERE userID = ? AND heat.productID = products.productID) AS heated, (SELECT COUNT(userID) FROM cold WHERE userID = ? AND cold.productID = products.productID) AS froze FROM products ORDER BY RAND() LIMIT 20;");
                    $getProducts->bind_param("ii", $_SESSION['uid'], $_SESSION['uid']);
                    $getProducts->execute();
                    $getProducts->bind_result($productID, $model, $assetURL, $heat, $cold, $min, $heated, $froze);
                } else {
                    $getProducts = $conn->prepare("SELECT products.productID, products.model, products.assetURL, (SELECT COUNT(*) FROM heat WHERE productID = products.productID) AS heat, (SELECT COUNT(*) FROM cold WHERE productID = products.productID) AS cold, (SELECT MIN(price) FROM offers WHERE productID = products.productID) AS minPrice FROM products ORDER BY RAND() LIMIT 20;");
                    $getProducts->execute();
                    $getProducts->bind_result($productID, $model, $assetURL, $heat, $cold, $min);
                }

                while($getProducts->fetch()) {
                    if($min === null) {
                        $low = '';
                    } else {
                        $low = '$'.$min.'+';
                    }

                    if(isset($_SESSION['uid'])) {
                        if($heated > 0) {
                            $statsClass = 'class="num_stats_v"';
                            $heatedClass = 'heated';
                            $frozeClass = 'cold';
                        } else if($froze > 0) {
                            $statsClass = 'class="num_stats_v"';
                            $frozeClass = 'froze';
                            $heatedClass = 'heat';
                        } else {
                            $statsClass = 'class="num_stats_h"';
                            $heatedClass = 'heat';
                            $frozeClass = 'cold';
                        }
                    } else {
                        $statsClass = 'class="num_stats_h"';
                        $heatedClass = 'heat';
                        $frozeClass = 'cold';
                    }

                    echo '
                    <div class="card">
                        <table>
                            <tr class="lowest_price" onclick="item('."'".$productID."'".')">
                                <td>'.$low.'</td>
                            </tr>
                            <tr class="item_asset" onclick="item('."'".$productID."'".')">
                                <td><img src="'.$assetURL.'" alt="'.$model.'"></td>
                            </tr>
                            <tr class="item_stats stats-'.$productID.'">
                                <td>
                                    <table style="width: 100%;">
                                        <tr '.$statsClass.' id="stats-'.$productID.'">
                                            <td style="width: 50%;" class="heat_stats" id="heat-stats-'.$productID.'">'.$heat.'</td>
                                            <td style="width: 50%;" class="cold_stats" id="cold-stats-'.$productID.'">'.$cold.'</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%;"><i class="fas fa-fire '.$heatedClass.'" title="Heat" id="heat-'.$productID.'" onclick="heat('.$productID.');"></i></td>
                                            <td style="width: 50%;"><i class="fas fa-snowflake '.$frozeClass.'" title="Pass" id="cold-'.$productID.'" onclick="cold('.$productID.');"></i></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr class="item_model" onclick="item('."'".$productID."'".')">
                                <td>'.$model.'</td>
                            </tr>
                        </table>
                    </div>
                    ';
                }
                $getProducts->close();
            ?>
            <div class="end_item"></div>
        </div>

        <div class="see_more">See More</div>

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