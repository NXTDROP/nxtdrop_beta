<?php 
    session_start();
    include "dbh.php";
    include "inc/time.php";

    if (!isset($_SESSION['uid'])) {
        header("Location: login.php");
    }
?>

<!DOCTYPE html>
<html>
    <title>
    NXTDROP: The Fashion Trade Centre
    </title>
    <head>
        <?php include('inc/head.php'); ?>
        <!-- Javascripts -->
        <script type="text/javascript" src="js/menu-dropdown.js"></script>
        <script type="text/javascript" src="js/post-popup.js"></script>
        <script type="text/javascript" src="js/messages.js"></script>
        <script type="text/javascript" src="js/msg-popup.js"></script>
        <script type="text/javascript" src="js/dm_icon.js"></script>
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
        <?php include('inc/inbox/message-body.php'); ?>
        <?php include('inc/inbox/new-msg.php'); ?>
        <?php include('inc/drop/new-drop-pop.php'); ?>
        <?php include('inc/inbox/image_preview.php'); ?>
    </body>
</html>