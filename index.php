<?php 
    session_start();
    include "dbh.php";
    include "inc/time.php";
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
        <script type="text/javascript">
            function previewImage (input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#preview').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
            $(document).ready(function() {
                $(".inputfile").change(function() {
                    previewImage(this);
                    $('#preview').show();
                    $('#cancel_preview').show();
                });

                $('#cancel_preview').click(function() {
                    $('.inputfile').val('');
                    $('#preview').hide();
                    $('#cancel_preview').hide();
                });
            });
        </script>
        <script type="text/javascript" src="js/dm_icon.js"></script>
    </head>
    <body>
        <?php include('inc/header-body.php'); ?>
        <?php include('inc/main-page-post.php'); ?>

        <p id="message"></p>

        <?php include('inc/new-drop-pop.php'); ?>
        <?php include('inc/new-msg-post.php'); ?>

        <section class="footer">
            <ul>
                <li><p>&copy NXTDROP Inc. 2017</p></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Terms &amp Privacy</a></li>
            </ul>
        </section>
    </body>
</html>