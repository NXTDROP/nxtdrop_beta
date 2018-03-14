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
        <base href="https://nxtdrop.com/">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link type="text/css" rel="stylesheet" href="main.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/menu-dropdown.js"></script>
        <script type="text/javascript" src="js/post-popup.js"></script>
        <script type="text/javascript" src="js/delete-post.js"></script>
        <script type="text/javascript" src="js/like-unlike-post.js"></script>
        <script type="text/javascript" src="js/dm_icon.js"></script>
    </head>
    <body>
        <?php include('inc/header-body.php'); ?>
        <?php include('inc/like-page-post.php'); ?>

        <p id="message"></p>

        <?php include('inc/new-drop-pop.php'); ?>
        <?php include('inc/new-msg-post.php'); ?>
        <?php include('inc/flag-post.php'); ?>


        <section class="footer">
            <ul>
                <li><p>&copy NXTDROP Inc. 2018</p></li>
                <li><a href="terms">Terms of Use</a></li>
                <li><a href="privacy">Privacy</a></li>
            </ul>
        </section>
    </body>
</html>