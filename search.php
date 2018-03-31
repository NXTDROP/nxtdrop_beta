<?php 
    session_start();
    include "dbh.php";
    include "inc/time.php";
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
        <script type="text/javascript">
            var numData = 5;
            var q = <?php echo "'".$_GET['q']."'"; ?>;
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

                var num = <?php include 'dbh.php'; echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE username LIKE '%".$_GET['q']."%'")); ?>;

                if (numData >= num) {
                    $('.load_users').hide();
                }

                $('.load_users').click(function() {
                    numData = numData + 5;
                    $.ajax({
                        type: 'POST',
                        url: 'inc/upload-search-users-results.php',
                        data: {numData: numData, q: q},
                        success: function(data) {
                            $('#container-users').html(data);
                        },
                        error: function() {
                            console.log('error');
                        }
                    });
                });
            });
        </script>
        <script type="text/javascript" src="js/dm_icon.js"></script>
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
        <?php include('inc/search-users-results.php'); ?>

        <?php include('inc/search-body.php'); ?>

        <p id="message"></p>

        <?php include('inc/new-drop-pop.php'); ?>

        <section class="footer">
            <ul>
                <li><p>&copy NXTDROP Inc. 2018</p></li>
                <li><a href="terms">Terms of Use</a></li>
                <li><a href="privacy">Privacy</a></li>
            </ul>
        </section>
    </body>
</html>