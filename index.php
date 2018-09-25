<?php 
    session_start();
    include "dbh.php";
    date_default_timezone_set("UTC");
    $_SESSION['timestamp'] = date("Y-m-d H:i:s", time());
    $num_post = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM posts;"));
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
                var renew;
                var count = 10;
                $('.refresh').html('<i class="fa fa-spinner fa-spin fa-2x" aria-hidden="true">').css('margin-top', '80px');

                $(window).scroll(function() {
                    var scroll = $(window).scrollTop();
                });

                $('.load_drop').click(function() {
                    clearTimeout(renew);
                    count += 10;
                    $(this).html('Loading...');
                    drop(count);
                });

                $('.refresh').click(function() {
                    $('.refresh').html('<i class="fas fa-sync fa-spin"></i>');
                    $.ajax({
                        url: 'inc/refresh-drop-page.php',
                        type: 'POST',
                        data: {count: count},
                        success: function(data) {
                            $('#posts-container').html(data);
                            $(window).scrollTop(0);
                        },
                        complete: function() {
                            $('.refresh').html('<i class="fas fa-sync fa-2x"></i>');
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
                            $('.refresh').html('<i class="fas fa-sync fa-2x"></i>').css('margin-top', '50px');
                            $('.load_drop').html('More Drops');
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
                            }, 20000);
                        }
                    });
                }
                /*$(".invite").fadeIn();
                $(".invite_main").show();*/
                drop(count);
            });    
        </script>
    </head>

    <body>
        <?php include('inc/navbar/navbar.php'); ?>

        <div class="refresh"></div>

        <div id="posts-container">
        </div>

        <?php
            if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM posts;")) >= 15) {
                $event_load = "ga('send', 'event', 'button', 'click', 'Buy Now Main');";
                echo '<button class="load_drop" onClick="'.$event_load.'">More Drops</button>';
            }
            else {
                echo '';
            }
        ?>
        <?php include('inc/drop/new-drop-pop.php'); ?>
        <?php include('inc/new-msg-post.php'); ?>
        <?php include('inc/flag-post.php'); ?>
        <?php include('inc/invite/popup.php'); ?>
        <?php include('inc/sold_pop.php') ?>
        <?php include('inc/search_pop.php') ?>
        <?php include('inc/buyer_transaction_confirmation.php') ?>
        <?php include('inc/notificationPopUp/sellerConfirmation.php') ?>
        <?php include('inc/notificationPopUp/MM_verification.php') ?>
        <?php include('inc/giveaway/popUp.php') ?>

        <p id="message"></p>

    </body>
</html>