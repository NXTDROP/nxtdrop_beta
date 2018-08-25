<?php 
    session_start();
    include 'dbh.php';
    include 'inc/num_conversion.php';
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
        echo ''.$fullname.'&#8217s closet &#x25FE NXTDROP: THE FASHION TRADE CENTER';
    ?>
    </title>
    <head>
        <?php include('inc/head.php'); ?>
        <!-- Javasripts -->
        <script type="text/javascript" src="js/menu-dropdown.js"></script>
        <script type="text/javascript" src="js/post-popup.js"></script>
        <script type="text/javascript" src="js/delete-post.js"></script>
        <script type="text/javascript" src="js/profile-picture.js"></script>
        <script type="text/javascript" src="js/like-unlike-post.js"></script>
        <script type="text/javascript" src="js/dm_icon.js"></script>
        <script>
            $(document).ready(function() {
                getPosts();
                $('#posts-btn').click(function() {
                    var posts =  $('#posts-btn').css('background-color');

                    if (posts == "rgb(170, 0, 0)") {
                        getPosts();
                        $('#likes-btn').css('background-color', '#aa0000');
                        $('#likes-btn').css('color', '#fff');
                        $('#reviews-btn').css('background-color', '#aa0000');
                        $('#reviews-btn').css('color', '#fff');
                    }
                });

                $('#likes-btn').click(function() {
                    var likes =  $('#likes-btn').css('background-color');

                    if (likes == "rgb(170, 0, 0)") {
                        getLikes();
                        $('#posts-btn').css('background-color', '#aa0000');
                        $('#posts-btn').css('color', '#fff');
                        $('#reviews-btn').css('background-color', '#aa0000');
                        $('#reviews-btn').css('color', '#fff');
                    }
                });

                $('#reviews-btn').click(function() {
                    var reviews =  $('#reviews-btn').css('background-color');

                    if (reviews == "rgb(170, 0, 0)") {
                        getReviews();
                        $('#posts-btn').css('background-color', '#aa0000');
                        $('#posts-btn').css('color', '#fff');
                        $('#likes-btn').css('background-color', '#aa0000');
                        $('#likes-btn').css('color', '#fff');
                    }
                });
            });

            function getPosts () {
                $('#posts-btn').css('background-color', '#fff');
                $('#posts-btn').css('color', '#aa0000');
                $('#display-profile').html('<p id="loading-profile">LOADING...</p>');
                $.ajax({
                    url: 'inc/profile-page-post.php',
                    type: 'GET',
                    data: {u: <?php echo "'".$_GET['u']."'"; ?>},
                    success: function(data) {
                        $('#display-profile').html(data);
                    }
                });
            }

            function getLikes () {
                $('#likes-btn').css('background-color', '#fff');
                $('#likes-btn').css('color', '#aa0000');
                $('#display-profile').html('<p id="loading-profile">LOADING...</p>');
                $.ajax({
                    url: 'inc/like-page-post.php',
                    type: 'GET',
                    data: {u: <?php echo "'".$_GET['u']."'"; ?>},
                    success: function(data) {
                        $('#display-profile').html(data);
                    }
                });
            }

            function getReviews () {
                $('#reviews-btn').css('background-color', '#fff');
                $('#reviews-btn').css('color', '#aa0000');
                $('#display-profile').html('<p id="loading-profile">LOADING...</p>');
                $.ajax({
                    url: 'inc/reviews-page.php',
                    type: 'GET',
                    data: {u: <?php echo "'".$_GET['u']."'"; ?>},
                    success: function(data) {
                        $('#display-profile').html(data);
                    }
                });
            }
        </script>
    </head>

    <body>
        <?php include('inc/navbar/navbar.php'); ?>
        <?php include("inc/profile-info.php"); ?>

        <div class="profile-navigation">
            <button id="posts-btn">POSTS</button>
            <button id="likes-btn">LIKES</button>
            <button id="reviews-btn">REVIEWS</button>
        </div>

        <div id="display-profile">
            
        </div>

        <p id="message"></p>

        <?php include('inc/drop/new-drop-pop.php'); ?>
        <?php include('inc/new-msg-post.php'); ?>
        <?php include('inc/flag-post.php'); ?>
        <?php include('inc/sold_pop.php') ?>
        <?php include('inc/search_pop.php') ?>
        <?php include('inc/buyer_transaction_confirmation.php') ?>
        <?php include('inc/follow_display.php') ?>

    </body>

</html>