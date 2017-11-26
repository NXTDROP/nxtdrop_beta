<?php 
    session_start();
    include "dbh.php";
?>
<!DOCTYPE html>
<html>
    <title>
        NXTDROP: The Social Marketplace
    </title>
    <head>
        <link type="text/css" rel="stylesheet" href="main.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/menu-dropdown.js"></script>
        <script type="text/javascript" src="js/post-popup.js"></script>
        <script type="text/javascript" src="js/delete-post.js"></script>
    </head>
    <body>
        <?php include('inc/header-body.php'); ?>
        <?php include('inc/main-page-post.php'); ?>

        <p id="message"></p>

        <div class="post">
            <div class="post_close close"></div>
            <div class="post_main">
                <h2>New Drop</h2>
                <div class="post_content">
                    <form action="post/post.php" method="POST" enctype="multipart/form-data" id="post" class="post-form">
                        <textarea name="caption" placeholder="Enter Description" id="caption"></textarea>
                        <input type="file" name="file" id="file" class="inputfile" accept="image/*" data-multiple-caption="{count} files selected" multiple />
                        <label for="file"><i class="fa fa-picture-o" aria-hidden="true"></i></label>
                        <button type="submit" name="submit" id="submit">Drop</button>
                    </form>
                </div>
            </div>
        </div>

        <section class="footer">
            <ul>
                <li><p>&copy NXTDROP Inc. 2017</p></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Terms &amp Privacy</a></li>
            </ul>
        </section>
    </body>
</html>