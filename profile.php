<?php 
    session_start();
    $db = 'dbh.php';
    require_once('login/rememberMe.php');
    include $db;
    include 'inc/num_conversion.php';
    require_once('inc/currencyConversion.php');
    function isFriend($uname) {
        include 'dbh.php';
        $follower_username = $uname;
        $user_id = $_SESSION['uid'];

        $sql = "SELECT * FROM users WHERE username='$follower_username'";
        $result = $conn->query($sql);
        $row = mysqli_fetch_assoc($result);
        $follower_id = $row['uid'];

        $query2 = "SELECT * FROM following WHERE user_id='$user_id' AND follower_id='$follower_id'";
        $result = $conn->query($query2);
        $count = mysqli_num_rows($result);
        if ($count < 1) {
            return true;
        }
        else {
            return false;
        }
    }
    include "inc/time.php";
    $fullname = $_GET['u'];
?>
<!DOCTYPE html>

<html>
    <title>
    <?php
        echo ''.$fullname.'&#8217s closet &#x25FE - NXTDROP - Canada&apos;s #1 Sneaker Marketplace';
    ?>
    </title>
    <head>
        <?php include('inc/head.php'); ?>
        <link rel="canonical" href="https://nxtdrop.com/u/<?php echo $fullname; ?>" />
        <!-- Javasripts -->
        <script type="text/javascript" src="js/menu-dropdown.js"></script>
        <script type="text/javascript" src="js/post-popup.js"></script>
        <script type="text/javascript" src="js/delete-post.js"></script>
        <script type="text/javascript" src="js/profile-picture.js"></script>
        <script type="text/javascript" src="js/like-unlike-post.js"></script>
        <script type="text/javascript" src="js/dm_icon.js"></script>
        <script>
            $(document).ready(function() {
                var num = 12;
                var username = <?php echo "'".$fullname."'"; ?>;

                $('#most-popular > .see_more').click(function() {
                    $('#most-popular > .see_more').html('<i class="fas fa-circle-notch fa-spin"></i>');
                    $.ajax({
                        url: 'inc/profile/getMore.php',
                        type: 'POST',
                        data: {num: num, username: username},
                        success: function(response) {
                            if(response != "ERROR") {
                                $(response).insertBefore('#most-popular > .end_item');
                                $('#most-popular > .see_more').html("See More");
                                num = num + 12;
                            }
                        }
                    });
                });

                $('#search-bar-closet').keyup(function(e) {
                    $('#search-closet-results').fadeIn();
                    var q = $(this).val();             
                    if(isEmpty(q) || isBlank(q)) {
                        $('#search-closet-results').hide();
                        $('#search-closet-results').fadeOut();
                    } else {
                        $.ajax({
                            url: 'inc/profile/searchCloset.php',
                            type: 'POST',
                            data: {q: q},
                            success: function(response) {
                                if(isBlank(response) || isEmpty(response)) {
                                    $('#search-closet-results').html('NO RESULT').css("text-align", "center");
                                } else {
                                    $('#search-closet-results').html(response);
                                }
                            }
                        });
                    }
                });
            });

            function editListing(productID, model) {
                $(".editListing_pop").fadeIn();
                $(".editListing_main").show();
                $('.editListing_main > h2').html(model);
                $(".editListing_content").html('<i class="fas fa-circle-notch fa-spin"></i>');

                $.ajax({
                    url: 'inc/profile/getlistings.php',
                    type: 'POST',
                    data: {productID: productID},
                    success: function(response) {
                        if(response == "not connected") {
                            $('.editListing_content').html('<p><i class="fa fa-exclamation-circle" aria-hidden="true"></i></p><p>Log in.</p>');
                        } else if(response == "error1") {
                            $('.editListing_content').html('<p><i class="fa fa-exclamation-circle" aria-hidden="true"></i></p><p>Error. Try later.</p>');
                        } else if(response == "DB") {
                            $('.editListing_content').html('<p><i class="fa fa-exclamation-circle" aria-hidden="true"></i></p><p>Error. Try later.</p>');
                        } else {
                            $('.editListing_content').html(response);
                        }
                    },
                    error: function() {
                        $('.editListing_content').html('<p><i class="fa fa-exclamation-circle" aria-hidden="true"></i></p><p>Error. Try later.</p>');
                    }
                });
            }

            function isBlank(str) {
                return (!str || /^\s*$/.test(str));
            }

            function isEmpty(str) {
                return (!str || 0 === str.length);
            }
        </script>
    </head>

    <body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-546WBVB"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
        <?php include('inc/navbar/navbar.php'); ?>
        <?php include("inc/profile-info.php"); ?>

        <div id="item-container">
            <?php
                if(isset($_GET['u']) && isset($_SESSION['uid']) && $_GET['u'] == $_SESSION['username']) {
                    echo '<div id="search-closet">
                        <input type="text" name="search" id="search-bar-closet" placeholder="Search your closet...">
                        <div id="search-closet-results">
        
                        </div>
                    </div>';
                }
            ?>
            <div id="most-popular">
                <?php
                    if(isset($_GET['u']) && isset($_SESSION['uid']) && $_GET['u'] == $_SESSION['username']) {
                        echo '<h2 id="feed-header">Your Closet</h2>';
                        $getCloset = $conn->prepare("SELECT p.productID, p.model, p.assetURL, MIN(o.price), COUNT(o.offerID) FROM users u, offers o, products p WHERE u.username = ? AND u.uid = o.sellerID AND o.productID = p.productID AND o.offerID NOT IN (SELECT * FROM (SELECT o.offerID FROM offers o, counterOffer r WHERE o.offerID = r.offerID UNION SELECT o.offerID FROM offers o, transactions t WHERE o.offerID = t.itemID AND t.status != 'cancelled' UNION SELECT o.offerID FROM offers o, reviewedCO r WHERE o.offerID = r.offerID AND r.status = 'accepted') AS A) GROUP BY p.model ORDER BY p.model ASC LIMIT 12;");
                        $getCloset->bind_param("s", $fullname);
                        $getCloset->execute();
                        $getCloset->bind_result($productID, $model, $assetURL, $min, $numListed);

                        while($getCloset->fetch()) {
                            if($min === null) {
                                $low = '';
                            } else {
                                $low = usdTocad($min, $db, true).'+';
                            }

                            if($numListed > 1) {
                                $numListed = $numListed.' Pairs';
                            } else {
                                $numListed = $numListed. ' Pair';
                            }

                            if(isset($_SESSION['uid'])) {
                                if($_SESSION['username'] == $fullname) {
                                    $onclick = 'onclick="editListing('."'".$productID."'".', '."'".$model."'".')"';
                                } else {
                                    $onclick = '';
                                }
                            } else {
                                $onclick = '';
                            }

                            echo '
                        <div class="card" id="'.$model.'">
                            <table>
                                <tr class="lowest_price" '.$onclick.'>
                                    <td>'.$low.'</td>
                                </tr>
                                <tr class="item_asset" '.$onclick.'>
                                    <td><img src="'.$assetURL.'" alt="'.$model.'"></td>
                                </tr>
                                <tr class="item_model" '.$onclick.'>
                                    <td>'.$model.'</td>
                                </tr>
                                <tr style="color: #555;">
                                <td>'.$numListed.'</td>
                                </tr>
                            </table>
                        </div>
                        ';
                        }

                        echo '<div class="end_item"></div>

                        <div class="see_more">See More</div>';

                        $getCloset->close();
                    }
                ?>
            </div>
        </div>

        <?php include('inc/drop/new-drop-pop.php'); ?>
        <?php include('inc/new-msg-post.php'); ?>
        <?php include('inc/flag-post.php'); ?>
        <?php include('inc/sold_pop.php') ?>
        <?php include('inc/search_pop.php') ?>
        <?php include('inc/buyer_transaction_confirmation.php') ?>
        <?php include('inc/follow_display.php') ?>
        <?php include('inc/profile/editListing.php'); ?>

    </body>

</html>