<?php 
    session_start();
    include "dbh.php";
    include "inc/time.php";
    date_default_timezone_set("UTC");
    $_SESSION['timestamp'] = date("Y-m-d H:i:s", time());
?>
<!DOCTYPE html>
<html>
    <title>
        NXTDROP: The Social Marketplace
    </title>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link type="text/css" rel="stylesheet" href="main.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/menu-dropdown.js"></script>
        <script type="text/javascript" src="js/post-popup.js"></script>
        <script type="text/javascript" src="js/delete-post.js"></script>
        <script type="text/javascript" src="js/like-unlike-post.js"></script>
        <script type="text/javascript" src="js/dm_icon.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                var count = 15;
                $('.refresh').html('<i class="fa fa-spinner fa-spin fa-2x" aria-hidden="true">').css('margin-top', '300px');

                $(window).scroll(function() {
                    var scroll = $(window).scrollTop();
                });

                $('.load_drop').click(function() {
                    count += 15;
                    $.ajax({
                        type: 'POST',
                        url: 'inc/main-page-post.php',
                        data: {count: count},
                        success: function(data) {
                            $('#posts-container').html(data);
                            $(window).scrollTop(scroll);
                        }
                    });
                });

                $('.refresh').click(function() {
                    $('.refresh').html('<i class="fa fa-refresh fa-spin fa-2x" aria-hidden="true">');
                    $.ajax({
                        url: 'inc/refresh-drop-page.php',
                        type: 'POST',
                        data: {count: count},
                        success: function(data) {
                            $('#posts-container').html(data);
                            $(window).scrollTop(0);
                        },
                        complete: function() {
                            $('.refresh').html('<i class="fa fa-refresh fa-2x" aria-hidden="true">');
                        }
                    });
                });

                function drop(count) {
                    $.ajax({
                        url: 'inc/main-page-post.php',
                        type: 'POST',
                        data: {count: count},
                        success: function(data) {
                            $('#posts-container').html(data);
                            $(window).scrollTop(scroll);
                            $('.refresh').html('<i class="fa fa-refresh fa-2x" aria-hidden="true">').css('margin-top', '100px');
                        },
                        complete: function() {
                            var renew = setTimeout(function() {
                                drop(count);
                            }, 10000);
                        }
                    });
                }
                drop(count);
            });    
        </script>
    </head>
    <body>
        <?php include('inc/header-body.php'); ?>
        <div class="refresh"></div>
        <div id="posts-container">
        </div>
        <?php include('inc/new-drop-pop.php'); ?>
        <?php include('inc/new-msg-post.php'); ?>
        <?php include('inc/flag-post.php'); ?>

        <p id="message"></p>

        <section class="footer">
            <ul>
                <li><p>&copy NXTDROP Inc. 2017</p></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Terms &amp Privacy</a></li>
            </ul>
        </section>
    </body>
</html>