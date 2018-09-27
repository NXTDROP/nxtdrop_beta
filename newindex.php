<?php 
    session_start();
    include "dbh.php";
    date_default_timezone_set("UTC");
    $_SESSION['timestamp'] = date("Y-m-d H:i:s", time());
    /*if (isset($_SESSION['uid'])) {
        date_default_timezone_set("UTC");
        $_SESSION['timestamp'] = date("Y-m-d H:i:s", time());
        $num_post = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM posts;"));
    }
    else {
        header("Location: welcome");
        exit();
    }*/
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
                
            });  

            function item(model) {
                window.location.replace('https://localhost/nd-v1.00/item.php?model='+model);
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
        </script>
    </head>

    <body>
        <?php include('inc/navbar/navbar.php'); ?>

        <div id="item-container">
            <?php
                $getProducts = $conn->prepare("SELECT products.productID, products.model, products.assetURL, (SELECT COUNT(*) FROM heat WHERE productID = products.productID) AS heat, (SELECT COUNT(*) FROM cold WHERE productID = products.productID) AS cold FROM products;");
                $getProducts->execute();
                $getProducts->bind_result($productID, $model, $assetURL, $heat, $cold);
                while($getProducts->fetch()) {
                    echo '
                    <div class="card">
                        <table>
                            <tr class="lowest_price" onclick="item('."'".$model."'".')">
                                <td>$0+</td>
                            </tr>
                            <tr class="item_asset" onclick="item('."'".$model."'".')">
                                <td><img src="'.$assetURL.'" alt="'.$model.'"></td>
                            </tr>
                            <tr class="item_stats stats-'.$productID.'">
                                <td>
                                    <table style="width: 100%;">
                                        <tr class="num_stats_h" id="stats-'.$productID.'">
                                            <td style="width: 50%;" class="heat_stats" id="heat-stats-'.$productID.'">'.$heat.'</td>
                                            <td style="width: 50%;" class="cold_stats" id="cold-stats-'.$productID.'">'.$cold.'</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%;"><i class="fas fa-fire heat" title="Heat" id="heat-'.$productID.'" onclick="heat('.$productID.');"></i></td>
                                            <td style="width: 50%;"><i class="fas fa-snowflake cold" title="Pass" id="cold-'.$productID.'" onclick="cold('.$productID.');"></i></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr class="item_model" onclick="item('."'".$model."'".')">
                                <td>'.$model.'</td>
                            </tr>
                        </table>
                    </div>
                    ';
                }
            ?>
        </div>

        <?php include('inc/talk/popup.php') ?>
        <?php include('inc/drop/new-drop-pop.php'); ?>
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