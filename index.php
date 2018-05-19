<?php 
    session_start();
    include "dbh.php";
    include "inc/time.php";
    date_default_timezone_set("UTC");
    $_SESSION['timestamp'] = date("Y-m-d H:i:s", time());
    $num_post = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM posts;"));
?>
<!DOCTYPE html>
<html>
    <title>
        NXTDROP: The Fashion Trade Centre
    </title>
    <head>
        <!--<base href="https://nxtdrop.com/">-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSS -->
        <link type="text/css" rel="stylesheet" href="main.css" /> 

        <!-- Bootstrap 4 Jquery & Popper.js -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>

        <!-- Bootstrap 4 CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

        <!-- Font-Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

        <!-- Jquery Library -->
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

        <!-- Javasripts -->
        <script type="text/javascript" src="js/menu-dropdown.js"></script>
        <script type="text/javascript" src="js/post-popup.js"></script>
        <script type="text/javascript" src="js/delete-post.js"></script>
        <script type="text/javascript" src="js/like-unlike-post.js"></script>
        <script type="text/javascript" src="js/dm_icon.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                var renew;
                var count = 15;
                $('.refresh').html('<i class="fa fa-spinner fa-spin fa-2x" aria-hidden="true">').css('margin-top', '300px');

                $(window).scroll(function() {
                    var scroll = $(window).scrollTop();
                });

                $('.load_drop').click(function() {
                    clearTimeout(renew);
                    count += 15;
                    $(this).html('Loading...');
                    drop(30);
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
                    var num_post = <?php echo $num_post; ?>;
                    $.ajax({
                        url: 'inc/main-page-post.php',
                        type: 'POST',
                        data: {count: count},
                        success: function(data) {
                            $('#posts-container').html(data);
                            $(window).scrollTop(scroll);
                            $('.refresh').html('<i class="fa fa-refresh fa-2x" aria-hidden="true">').css('margin-top', '50px');
                        },
                        complete: function() {
                            if (count >= num_post) {
                                $('.load_drop').css('display', 'none');
                            }
                            else {
                                $('.load_drop').css('display', 'block');
                            }
                            renew = setTimeout(function() {
                                drop(count);
                            }, 10000);
                        }
                    });
                }
                $(".invite").fadeIn();
                $(".invite_main").show();
                drop(count);
            });    
        </script>

        <!-- Facebook Pixel Code -->
        <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod? n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1908028209510021');
        fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=1908028209510021&ev=PageView&noscript=1"/></noscript>
        <!-- End Facebook Pixel Code -->
    </head>

    <body>
        <?php include('inc/header-body.php'); ?>

        <?php include('inc/carousel.php'); ?>

        <div class="refresh"></div>

        <div id="posts-container">
        </div>

        <?php
            if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM posts;")) >= 15) {
                echo '<button class="load_drop">More Drops</button>';
            }
            else {
                echo '';
            }
        ?>
        <?php include('inc/drop/new-drop-pop.php'); ?>
        <?php include('inc/new-msg-post.php'); ?>
        <?php include('inc/flag-post.php'); ?>
        <?php include('inc/invite/popup.php') ?>
        <?php include('inc/sold_pop.php') ?>

        <p id="message"></p>

        <section class="footer">
            <ul>
                <li><p>&copy NXTDROP Inc. 2018</p></li>
                <li><a href="terms">Terms of Use</a></li>
                <li><a href="privacy">Privacy</a></li>
            </ul>
        </section>
    </body>
</html>