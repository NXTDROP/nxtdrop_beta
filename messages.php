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
        <?php include('inc/navbar/navbar.php'); ?>
        <?php include('inc/inbox/message-body.php'); ?>
        <?php include('inc/inbox/new-msg.php'); ?>
        <?php include('inc/drop/new-drop-pop.php'); ?>
        <?php include('inc/search_pop.php') ?>
        <?php include('inc/inbox/image_preview.php'); ?>
        <?php include('inc/giveaway/popUp.php') ?>
    </body>
</html>