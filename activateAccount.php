<?php 
    if(isset($_GET['email'])) {
        $email = $_GET['email'];
    }
    else {
        $email = '';
    }
?>
<!DOCTYPE html>

<html>
    <title>
    NXTDROP: The Fashion Trade Centre
    </title>
    <head>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-546WBVB');</script>
<!-- End Google Tag Manager -->
        <base href="https://nxtdrop.com/">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link type="text/css" rel="stylesheet" href="unsubscribe.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- Font-Awesome -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>
    </head>

    <body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-546WBVB"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
        <header>
            <a href="home"><img id ="logo"src="img/nxtdroplogo.png" width="125px"></a>
        </header>

        <script>
            $(document).ready(function() {
                $('.load').fadeIn();
                $('.load_main').show();
                var email = <?php echo "'".$email."'"; ?>;

                if(email != '') {
                    $.ajax({
                        url: 'inc/accountActivation/activateAccount.php',
                        type: 'POST',
                        data: {email: email},
                        success: function(response) {
                            if(response === 'DB') {
                                console.log(response);
                                $('.container').html('<p>There was an error. Try Later!</p></br><p>We are sorry for the inconvenience.</p><p>Team NXTDROP.</p>');
                                $('.load').fadeOut();
                                $('.load_main').fadeOut();
                            }
                            else if(response === '') {
                                console.log(response);
                                $('.container').html('<p>Your account has been activated.</p><p>Thank you for joining NXTDROP.</p></br><p>Hope to see you soon!</p><p>Team NXTDROP</p>');
                                $('.load').fadeOut();
                                $('.load_main').fadeOut();
                            }
                            else if(response === 'DONE') {
                                console.log(response);
                                $('.container').html('<p>You account has already been activated. See you.</p><p>Team NXTDROP.</p>');
                                $('.load').fadeOut();
                                $('.load_main').fadeOut();
                            }
                            else {
                                console.log(response);
                                $('.container').html('<p>There was an error. Try Later!</p></br><p>We are sorry for the inconvenience.</p><p>Team NXTDROP.</p>');
                                $('.load').fadeOut();
                                $('.load_main').fadeOut();
                            }
                        },
                        error: function(response) {
                            $('.container').html('<p>There was an error. Try Later!</p></br><p>We are sorry for the inconvenience.</p><p>Team NXTDROP.</p>');
                            console.log(response);
                            $('.load').fadeOut();
                            $('.load_main').fadeOut();
                        }   
                    });
                } else {
                    $('.container').html('<p>There was an error. Try Later!</p></br><p>We are sorry for the inconvenience.</p><p>Team NXTDROP.</p>');
                    $('.load').fadeOut();
                    $('.load_main').fadeOut();
                }
            });
        </script>
        
        <div class="container">
            <?php 
                if(!isset($_GET['email'])) {
                    echo '<p style="color: red;">Error</p>';
                }
            ?>
        </div>
        <?php include('inc/checkout/loadingInfo.php'); ?>
        <?php include('regis/social_regis.php'); ?>
    </body>
</html>