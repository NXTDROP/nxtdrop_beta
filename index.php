<?php 
    session_start();
    include 'dbh.php';
    $db = 'dbh.php';
    require_once('login/rememberMe.php');
    require_once('inc/currencyConversion.php');

    $checkLastSale = $conn->prepare("SELECT updated FROM last_sale;");
    $checkLastSale->execute();
    $checkLastSale->bind_result($update);
    $checkLastSale->fetch();
    $diff = strtotime(date("Y-m-d H:i:s", time())) - strtotime($update);
    $diff = $diff / 60;
    $checkLastSale->close();

    if($diff > 20) {
        $getNewOffer = $conn->prepare("SELECT offerID from offers ORDER BY RAND() LIMIT 1;");
        $getNewOffer->execute();
        $getNewOffer->bind_result($offerID);
        $getNewOffer->fetch();
        $getNewOffer->close();

        $updateLastSale = $conn->prepare("UPDATE last_sale SET offerID = ?, updated = ? WHERE updated = ?");
        $updateLastSale->bind_param('iss', $offerID, $date, $update);
        $date = date("Y-m-d H:i:s", time());
        $updateLastSale->execute();
        $updateLastSale->close();
    }


    //$40 OFF
    /*if(isset($_SESSION['uid'])) {
        $checkCode = $conn->prepare("SELECT COUNT(*) FROM discountCode WHERE assignedTo = ?");
        $checkCode->bind_param('i', $userID);
        $userID = $_SESSION['uid'];
        $checkCode->execute();
        $checkCode->bind_result($count);
        $checkCode->fetch();
    }*/

    if(!isset($_SESSION['uid']) && isset($_SESSION['last_visit']) && (time() - $_SESSION['last_visit'] > 600)) {
        session_unset();
        session_destroy();
    }
?>
<!DOCTYPE html>
<html>
    <title>
        NXTDROP - Canada's #1 Sneaker Marketplace: Buy and Sell Authentic Sneakers
    </title>
    <head>
        <?php include('inc/head.php'); ?>
        <link rel="canonical" href="https://nxtdrop.com" />
        <meta name="google-site-verification" content="gtQha3Cxmccl9OP-yqL0bohCuLMM5TbHK9eh0rUeVzU" />
        <!-- Javasripts -->
        <script type="text/javascript" src="js/delete-post.js"></script>
        <script type="text/javascript" src="js/like-unlike-post.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                checkTalk();
                var num_MP = 4;
                var num_NR = 4;

                $('.carousel').carousel({
                    interval: 6000
                });
                
                /*$40 OFF */
                /*setTimeout(() => {
                    <?php
                        /*if(isset($_SESSION['uid'])) {
                            if($count < 1) {
                                echo "$('.pop').fadeIn(); $('.pop_main').show();";
                            }
                            $checkCode->close();
                        }*/
                    ?>
                }, 2500);*/

                $('#feed > .see_more').click(function() {
                    $('#feed > .see_more').html('<i class="fas fa-circle-notch fa-spin"></i>');
                    $.ajax({
                        url: 'inc/feed/getMore.php',
                        type: 'POST',
                        success: function(response) {
                            if(response != "ERROR") {
                                $(response).insertBefore('#feed > .end_item');
                                $('#feed > .see_more').html("See More");
                            }
                        }
                    });
                });

                $('#most-popular > .see_more').click(function() {
                    $('#most-popular > .see_more').html('<i class="fas fa-circle-notch fa-spin"></i>');
                    $.ajax({
                        url: 'inc/feed/getMoreMP.php',
                        type: 'POST',
                        data: {num: num_MP},
                        success: function(response) {
                            if(response != "ERROR") {
                                $(response).insertBefore('#most-popular > .end_item');
                                $('#most-popular > .see_more').html("See More");
                                num_MP = num_MP + 20;
                            }
                        }
                    });
                });

                $('#new-releases > .see_more').click(function() {
                    $('#new-releases > .see_more').html('<i class="fas fa-circle-notch fa-spin"></i>');
                    $.ajax({
                        url: 'inc/feed/getMoreNR.php',
                        type: 'POST',
                        data: {num: num_NR},
                        success: function(response) {
                            if(response != "ERROR") {
                                $(response).insertBefore('#new-releases > .end_item');
                                $('#new-releases > .see_more').html("See More");
                                num_NR = num_NR + 12;
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

            /* PROMO CODE */
            function promo(productID, assetURL, releaseDate, retailPrice, model, brand, connected) {
                if(!connected) {
                    window.location.href = 'signup';
                } else {
                    promoProductID = productID;
                    assetURL = assetURL;
                    releaseDate = releaseDate;
                    retailPrice = retailPrice;
                    model = model;
                    brand = brand;

                    $('#brand').html(brand);
                    $('#releaseDate').html(releaseDate);
                    $('#model').html(model);
                    $('.promo_main > h2').html(model);
                    $('#retailPrice').html(retailPrice);
                    $('.promo_content > img').attr('src', assetURL);

                    $('.promo_pop').fadeIn();
                    $('.promo_main').show();
                }
            }
        </script>
    </head>

    <body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-546WBVB"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
        <?php include('inc/navbar/navbar.php'); ?>

        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                <img class="d-block w-100" src="img/AirFearOfGODWhite.png" alt="Air Fear of God White Banner">
                </div>
                <div class="carousel-item">
                <img class="d-block w-100" src="img/YeezyMauveCarousel.png" alt="Yeezy Mauve Banner">
                </div>
                <div class="carousel-item">
                <img class="d-block w-100" src="img/NotForResale.png" alt="Not For Resale Banner">
                </div>
                <div class="carousel-item">
                <img class="d-block w-100" src="img/UnionXaj1.png" alt="Jordan 1 Retro High Union LA Banner">
                </div>
            </div>
        </div>

        <?php
            $getLastSale = $conn->prepare("SELECT products.assetURL, products.productID, products.model, offers.price FROM offers, last_sale, products WHERE last_sale.offerID = offers.offerID AND offers.productID = products.productID;");
            $getLastSale->execute();
            $getLastSale->bind_result($assetURL, $productID, $model, $price);
            $getLastSale->fetch();
            echo '<div id="last_sale">
                    <a href="sneakers/'.$productID.'">
                        <table>
                            <tr>
                                <td style="width: 15%; padding: 5px;"><p style="letter-spacing: 2px; color: #e53232; font-size: 30px; font-weight: bolder;">LAST SALE</p></td>
                                <td><img src="'.$assetURL.'" alt="'.$model.'"></td>
                                <td style="width: 15%; padding: 5px;">
                                    <p>'.$model.'</p>
                                    <p style="font-size: 28px; color: #85bb65;">'.usdTocad($price, $db, true).'</p>
                                </td>
                            </tr>
                        </table>
                    </a>
                </div>';
            $getLastSale->close();      
        ?>

        <div id="item-container">
            <div id="most-popular">
                <h2 id="feed-header">Most Popular</h2>
                <?php
                    if(isset($_SESSION['uid'])) {
                        $getMostPopular = $conn->prepare("SELECT products.productID, products.model, products.assetURL, (SELECT COUNT(*) FROM heat WHERE productID = products.productID) AS heat, (SELECT COUNT(*) FROM cold WHERE productID = products.productID) AS cold, (SELECT MIN(price) FROM offers WHERE offers.productID = products.productID AND offers.offerID NOT IN (SELECT * FROM (SELECT o.offerID FROM offers o, reviewedCO r WHERE o.offerID = r.offerID AND r.status = 'accepted') AS A UNION (SELECT o.offerID FROM offers o, transactions t WHERE o.offerID = t.itemID AND t.status != 'cancelled'))) AS minPrice, (SELECT COUNT(userID) FROM heat WHERE userID = ? AND heat.productID = products.productID) AS heated, (SELECT COUNT(userID) FROM cold WHERE userID = ? AND cold.productID = products.productID) AS froze FROM products, product_rank WHERE products.productID = product_rank.productID ORDER BY product_rank.rank DESC LIMIT 4;");
                        $getMostPopular->bind_param("ii", $_SESSION['uid'], $_SESSION['uid']);
                        $getMostPopular->execute();
                        $getMostPopular->bind_result($productID, $model, $assetURL, $heat, $cold, $min, $heated, $froze);
                    } else {
                        $getMostPopular = $conn->prepare("SELECT products.productID, products.model, products.assetURL, (SELECT COUNT(*) FROM heat WHERE productID = products.productID) AS heat, (SELECT COUNT(*) FROM cold WHERE productID = products.productID) AS cold, (SELECT MIN(price) FROM offers WHERE offers.productID = products.productID AND offers.offerID NOT IN (SELECT * FROM (SELECT o.offerID FROM offers o, reviewedCO r WHERE o.offerID = r.offerID AND r.status = 'accepted') AS A UNION (SELECT o.offerID FROM offers o, transactions t WHERE o.offerID = t.itemID AND t.status != 'cancelled'))) AS minPrice FROM products, product_rank WHERE products.productID = product_rank.productID ORDER BY product_rank.rank DESC LIMIT 4;");
                        $getMostPopular->execute();
                        $getMostPopular->bind_result($productID, $model, $assetURL, $heat, $cold, $min);
                    }

                    while($getMostPopular->fetch()) {
                        if($min === null) {
                            $low = '';
                        } else {
                            $low = usdTocad($min, $db, true).'+';
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

                    $getMostPopular->close();
                ?>

                <div class="end_item"></div>

                <div class="see_more">See More</div>
            </div>

            <div id="new-releases">
                <h2 id="feed-header">New Releases</h2>
                <?php
                    $dateToday = date("Y-m-d", time());
                    if(isset($_SESSION['uid'])) {
                        $getNewReleases = $conn->prepare("SELECT products.productID, products.model, products.assetURL, (SELECT COUNT(*) FROM heat WHERE productID = products.productID) AS heat, (SELECT COUNT(*) FROM cold WHERE productID = products.productID) AS cold, (SELECT MIN(price) FROM offers WHERE offers.productID = products.productID AND offers.offerID NOT IN (SELECT * FROM (SELECT o.offerID FROM offers o, reviewedCO r WHERE o.offerID = r.offerID AND r.status = 'accepted') AS A UNION (SELECT o.offerID FROM offers o, transactions t WHERE o.offerID = t.itemID AND t.status != 'cancelled'))) AS minPrice, (SELECT COUNT(userID) FROM heat WHERE userID = ? AND heat.productID = products.productID) AS heated, (SELECT COUNT(userID) FROM cold WHERE userID = ? AND cold.productID = products.productID) AS froze FROM products WHERE products.yearMade <= ? ORDER BY products.yearMade DESC LIMIT 4;");
                        $getNewReleases->bind_param("iis", $_SESSION['uid'], $_SESSION['uid'], $dateToday);
                        $getNewReleases->execute();
                        $getNewReleases->bind_result($productID, $model, $assetURL, $heat, $cold, $min, $heated, $froze);
                    } else {
                        $getNewReleases = $conn->prepare("SELECT products.productID, products.model, products.assetURL, (SELECT COUNT(*) FROM heat WHERE productID = products.productID) AS heat, (SELECT COUNT(*) FROM cold WHERE productID = products.productID) AS cold, (SELECT MIN(price) FROM offers WHERE offers.productID = products.productID AND offers.offerID NOT IN (SELECT * FROM (SELECT o.offerID FROM offers o, reviewedCO r WHERE o.offerID = r.offerID AND r.status = 'accepted') AS A UNION (SELECT o.offerID FROM offers o, transactions t WHERE o.offerID = t.itemID AND t.status != 'cancelled'))) AS minPrice FROM products WHERE products.yearMade <= ? ORDER BY products.yearMade DESC LIMIT 4;");
                        $getNewReleases->bind_param("s", $dateToday);
                        $getNewReleases->execute();
                        $getNewReleases->bind_result($productID, $model, $assetURL, $heat, $cold, $min);
                    }

                    while($getNewReleases->fetch()) {
                        if($min === null) {
                            $low = '';
                        } else {
                            $low = usdTocad($min, $db, true).'+';
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

                    $getNewReleases->close();
                ?>

                <div class="end_item"></div>

                <div class="see_more">See More</div>
            </div>

            <div id="feed">
                <h2 id="feed-header">Discovery</h2>
                <?php
                    if(isset($_SESSION['uid'])) {
                        $getProducts = $conn->prepare("SELECT products.productID, products.model, products.assetURL, (SELECT COUNT(*) FROM heat WHERE productID = products.productID) AS heat, (SELECT COUNT(*) FROM cold WHERE productID = products.productID) AS cold, (SELECT MIN(price) FROM offers WHERE offers.productID = products.productID AND offers.offerID NOT IN (SELECT * FROM (SELECT o.offerID FROM offers o, reviewedCO r WHERE o.offerID = r.offerID AND r.status = 'accepted') AS A UNION (SELECT o.offerID FROM offers o, transactions t WHERE o.offerID = t.itemID AND t.status != 'cancelled'))) AS minPrice, (SELECT COUNT(userID) FROM heat WHERE userID = ? AND heat.productID = products.productID) AS heated, (SELECT COUNT(userID) FROM cold WHERE userID = ? AND cold.productID = products.productID) AS froze FROM products ORDER BY RAND() LIMIT 12;");
                        $getProducts->bind_param("ii", $_SESSION['uid'], $_SESSION['uid']);
                        $getProducts->execute();
                        $getProducts->bind_result($productID, $model, $assetURL, $heat, $cold, $min, $heated, $froze);
                    } else {
                        $getProducts = $conn->prepare("SELECT products.productID, products.model, products.assetURL, (SELECT COUNT(*) FROM heat WHERE productID = products.productID) AS heat, (SELECT COUNT(*) FROM cold WHERE productID = products.productID) AS cold, (SELECT MIN(price) FROM offers WHERE offers.productID = products.productID AND offers.offerID NOT IN (SELECT * FROM (SELECT o.offerID FROM offers o, reviewedCO r WHERE o.offerID = r.offerID AND r.status = 'accepted') AS A UNION (SELECT o.offerID FROM offers o, transactions t WHERE o.offerID = t.itemID AND t.status != 'cancelled'))) AS minPrice FROM products ORDER BY RAND() LIMIT 12;");
                        $getProducts->execute();
                        $getProducts->bind_result($productID, $model, $assetURL, $heat, $cold, $min);
                    }

                    while($getProducts->fetch()) {
                        if($min === null) {
                            $low = '';
                        } else {
                            $low = usdTocad($min, $db, true).'+';
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

                <div class="see_more">See More</div>
            </div>
        </div>

        <?php require_once('inc/footer.php'); ?>
        <?php require_once('inc/feed/promoPopUp.php'); ?>

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
        <?php //include('inc/notificationPopUp/signUp.php'); ?>
        <?php //include('inc/giveaway/popUp.php') ?>

        <p id="message"></p>

    </body>
</html>