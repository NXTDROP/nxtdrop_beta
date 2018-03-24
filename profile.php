<?php 
    session_start();
    include "dbh.php";
    //include("inc/upload-profile-picture.php");
    include "inc/time.php";
    $username = $_GET['u'];
    $query = "SELECT * FROM users WHERE username='$username';";
    $result = mysqli_query($conn, $query);
    if ($data = mysqli_fetch_assoc($result)) {
        $fullname = $data['first_name'].' '.$data['last_name'];
    }
?>
<!DOCTYPE html>

<html>
    <title>
    <?php
        echo ''.$fullname.'&#8217s closet &#x25FE ('.$username.') &#x25FE NXTDROP: THE FASHION TRADE CENTER';
    ?>
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
        <script type="text/javascript" src="js/profile-picture.js"></script>
        <script type="text/javascript" src="js/like-unlike-post.js"></script>
        <script type="text/javascript" src="js/dm_icon.js"></script>
    </head>

    <body>
        <?php include('inc/header-body.php'); ?>
        <?php include("inc/profile-info.php"); ?>

        <?php include('inc/profile-page-post.php'); ?>

        <p id="message"></p>

        <?php include('inc/new-drop-pop.php'); ?>
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