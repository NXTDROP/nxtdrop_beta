<?php 
    session_start();
    include "dbh.php";
    if (isset($_SESSION['uid'])) {
        date_default_timezone_set("UTC");
        $_SESSION['timestamp'] = date("Y-m-d H:i:s", time());
        $num_post = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM posts;"));
    }
    else {
        header("Location: welcome");
        exit();
    }
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
    </head>

    <body>
        <script>
            window.fbAsyncInit = function() {
                FB.init({
                appId      : '{your-app-id}',
                cookie     : true,
                xfbml      : true,
                version    : '{api-version}'
                });
                
                FB.AppEvents.logPageView();   
                
            };

            (function(d, s, id){
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement(s); js.id = id;
                js.src = "https://connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        <?php include('inc/navbar/navbar.php'); ?>

        <div id="posts-container">
        <?php
        include 'inc/time.php';
        include 'inc/num_conversion.php';
        $pid = $_GET['p'];
        $sql = "SELECT * FROM posts, profile, users WHERE posts.pid = '$pid' AND profile.uid = posts.uid AND profile.uid = users.uid";
        $result = mysqli_query($conn, $sql);

        if (!mysqli_num_rows($result) > 0) {
            echo '<p id="no_post">No Posts Available!</p>';
        }
        else {
            $row = mysqli_fetch_assoc($result);
            if ($row['status'] == "") $row['status'] = "uploads/user.png";

                $like_class = 'far fa-heart like';
                if (isset($_SESSION['uid'])) {
                    $query = "SELECT pid FROM likes WHERE liked_by = ".$_SESSION['uid']." AND pid = ".$row['pid'].";";
                    $q_result = mysqli_query($conn, $query);
                    $q_row = mysqli_fetch_assoc($q_result);
                    if ($row['pid'] == $q_row['pid']) $like_class = 'fas fa-heart unlike';
                }

                $username = "'".$row['username']."'";
                $pid = $row['pid'];
                
                echo '<section class="container post-'.$row['pid'].'">
                <div class="card">
                <div class="card-header">
                                    
                <div class="profile-info">
                <div class="profile-img-index"><img class="post-small-img" src="'.$row['status'].'"></div>
                <div class="name"><span><a href="u/'.$row['username'].'">'.$row['username'].'</a></span>';
                echo '</div>';

                echo '<!--<div class="location">Toronto, Ontario</div>-->';
                
                if ($row['type'] == 'sale') {
                    echo '<p class="drop_type" id="sale_banner">SALE</p>';
                }
                else if ($row['type'] == 'request') {
                    echo '<p class="drop_type" id="request_banner">REQUEST</p>';
                }
                else if ($row['type'] == 'trade') {
                    echo '<p class="drop_type" id="trade_banner">TRADE</p>';
                }
            
                echo '</div>
            
                <div class="time">
                <p>'.getPostTime($row['pdate']).'</p>
                </div>
                </div>';

                if ($row['pic'] != '') {
                    echo '<div class="content">
                    <img src="'.$row['pic'].'">
                    </div>';
                }
            
                echo '<div class="card-footer">
            
                <div class="description">
                <p><span class="caption"><span class="name_caption"><a href="u/'.$row['username'].'">'.$row['username'].'</a></span> '.$row['caption'].'</span></p>';
                if ($row['type'] == 'sale') {
                    echo '<p id="price_budget">Price: <span id="cash">$'.$row['product_price'].'</span></p>';
                }
                else if ($row['type'] == 'request') {
                    echo '<p id="price_budget">Budget: <span id="cash">$'.$row['product_price'].'</span></p>';
                }
                else if ($row['type'] == 'trade') {
                    echo '<p id="trading_for">Trading for: <span id="trade_items">'.$row['product_price'].'</span></p>';
                }
                echo '</div>
                <!--<div class="comments">
                <p>
                <span class="username">Youssoupha24</span> Nice shoes.
                </p>
                <p>
                <span class="username">Blvckpvblo</span> Wanna trade with my Jordan IV?.
                </p>
                </div>-->
                <hr />';
                if (isset($_SESSION['uid'])) {
                    if ($_SESSION['uid'] == $row['uid']) {
                        $id = "'"."heart-".$row['pid']."'";
                        echo '
                    <div class="post_form_bottom">
                    <input type="hidden" name="pid" value="'.$row['pid'].' id="pid">
                    <div class="heart">';
                    echo '<span class="fa-layers fa-fw" id="likes-'.$row['pid'].'"><i class="'.$like_class.'" id="heart-'.$row['pid'].'" onclick="like(this.id, '.$row['pid'].', '.$row['uid'].', '.$row['likes'].')" title="Likes"></i><span class="fa-layers-counter" id="count-'.$row['pid'].'" style="background:Tomato">'.likes($row['likes']).'</span></span>';
                    echo '</div>';
                    
                    if ($row['uid'] != 'request') {
                        $type = 0;
                        echo '<div class="sold_button">
                    <button id="sold_button" onclick="sold('.$pid.', '.$type.')" title="Sold Already? Click Here! ">SOLD OUT?</button>
                    </div>';
                    }
                    else {
                        $type = 1;
                        echo '<div class="sold_button">
                    <button id="sold_button" onclick="sold('.$pid.', '.$type.')" title="Found Already? Click Here! ">FOUND?</button>
                    </div>';
                    }

                    echo '<div onclick="delete_('.$row['pid'].')" class="remove">
                    <i class="fa fa-times" aria-hidden="true" title="Delete Drop"></i>
                    </div>
                    
                    <!--<div class="add-comment">
                    <input type="text" placeholder="Drop a comment..." />
                    </div>-->
                    </div>
                    </div>
                    
                    </div>    
                    </section>';
                    } 
                    else {
                        $u = "'".$row['username']."'";
                        $pid = $row['pid'];
                        echo '
                    <div class="post_form_bottom">
                    <input type="hidden" name="pid" value="'.$row['pid'].'">
                    <div class="heart_noremove">';
                    echo '<span class="fa-layers fa-fw" id="likes-'.$row['pid'].'"><i class="'.$like_class.'" id="heart-'.$row['pid'].'" onclick="like(this.id, '.$row['pid'].', '.$row['uid'].', '.$row['likes'].')" title="Likes"></i><span class="fa-layers-counter" id="count-'.$row['pid'].'" style="background:Tomato">'.likes($row['likes']).'</span></span>';
                    echo '</div>
                    <div class="direct_message">
                    <button onclick="send('.$u.', '.$pid.')" title="Send Offer">SEND OFFER</button>
                    </div>
                    <div class="flag">
                    <i class="fa fa-flag" aria-hidden="true" onclick="flag('.$row['pid'].')" title="Report Drop"></i>
                    </div>
                
                    <!--<div class="add-comment">
                    <input type="text" placeholder="Drop a comment..." />
                    </div>-->
                    </div>
                    </div>
                
                    </div>    
                    </section>';
                    }
                    
                }
                else {
                    echo '
                    <div class="post_form_bottom">
                    <input type="hidden" name="pid" value="'.$row['pid'].'">
                    <div class="heart_noremove">';
                    echo '<span class="fa-layers fa-fw" id="likes-'.$row['pid'].'"><i class="'.$like_class.'" id="heart-'.$row['pid'].'" title="Likes"></i><span class="fa-layers-counter" style="background:Tomato">'.likes($row['likes']).'</span></span>';
                    echo '</div>
                    <div class="flag">
                    <i class="fa fa-flag" aria-hidden="true" title="Report Drop"></i>
                    </div>
                
                    <!--<div class="add-comment">
                    <input type="text" placeholder="Drop a comment..." />
                    </div>-->
                    </div>
                    </div>
                
                    </div>    
                    </section>';
                }
        }
    ?>
        </div>
        <?php include('inc/drop/new-drop-pop.php'); ?>
        <?php include('inc/new-msg-post.php'); ?>
        <?php include('inc/flag-post.php'); ?>
        <?php include('inc/sold_pop.php') ?>
        <?php include('inc/search_pop.php') ?>
        <?php include('inc/buyer_transaction_confirmation.php') ?>

        <p id="message"></p>

    </body>
</html>