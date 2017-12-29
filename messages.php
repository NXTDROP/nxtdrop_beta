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
        NXTDROP: The Social Marketplace
    </title>
    <head>
            <link type="text/css" rel="stylesheet" href="messages.css" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
            <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
            <script type="text/javascript" src="js/menu-dropdown.js"></script>
            <script type="text/javascript" src="js/post-popup.js"></script>
            <script src="js/messages.js"></script>
            <script src="js/msg-popup.js"></script>
            <script type="text/javascript" src="js/dm_icon.js"></script> 

    </head>

    <body>
        <?php include('inc/header-body.php'); ?>
                
        <?php include('inc/message-body.php') ?>

        <?php include('inc/new-msg.php'); ?>
        <?php include('inc/new-drop-pop.php'); ?>

        <section class="footer">
            <ul>
                <li><p>&copy NXTDROP Inc. 2017</p></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Terms &amp Privacy</a></li>
            </ul>
        </section>
                
    </body>
</html>