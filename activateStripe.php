<?php 
    include 'dbh.php';
    session_start();

    require_once('../credentials.php');
    require_once('vendor/autoload.php');
    \Stripe\Stripe::setApiKey($STRIPE_LIVE_SECRET_KEY);
    date_default_timezone_set("UTC"); 
    $date = date("Y-m-d H:i:s", time());
    $email = $_GET['email'];
    $getCountry = $conn->query("SELECT country FROM users WHERE email = '$email'");
    $data = $getCountry->fetch_assoc();
    if($data['country'] != '') {
        $gotCountry = '1';
    } else {
        $gotCountry = '0';
    }

    $country = $data['country'];
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
        <link type="text/css" rel="stylesheet" href="logstylesheet.css" />
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
                var gotCountry = <?php echo $gotCountry; ?>;
                $('#social_submit').html('Update Account');
                $('#social_username').hide();
                if(gotCountry === 1) {
                    $('.load').fadeIn();
                    $('.load_main').show();

                    $.ajax({
                        url: 'inc/accountActivation/paymentRegistration.php',
                        type: 'POST',
                        data: {email: <?php echo "'".$_GET['email']."'"; ?>},
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
                    $('.social_regis').fadeIn();
                    $('.social_regis_main').show();
                }

                $('#social_submit').click(function() {
                    var country = $('#social_country').val();
                    var email = '<?php echo $_GET['email']; ?>';
                    alert(country +  ' ' + email);
                    if(country === '') {
                        $('#social_form-message').html('Please enter your country. If your country is not listed, you cannot use this platform to buy or sell at this moment.');
                    } else {
                        $('.load').fadeIn();
                        $('.load_main').show();

                        $.ajax({
                            url: 'inc/accountActivation/paymentRegistration.php',
                            type: 'POST',
                            data: {email: email, country: country},
                            success: function(response) {
                                if(response === 'DB') {
                                    $('.container').html('<p>There was an error. Try Later!</p></br><p>We are sorry for the inconvenience.</p><p>Team NXTDROP.</p>');
                                    $('.load').fadeOut();
                                    $('.load_main').fadeOut();
                                    $('.social_regis').fadeOut();
                                    $('.social_regis_main').fadeOut();
                                }
                                else if(response === '') {
                                    $('.container').html('<p>Your account has been activated.</p><p>Thank you for joining NXTDROP.</p></br><p>Hope to see you soon!</p><p>Team NXTDROP</p>');
                                    $('.load').fadeOut();
                                    $('.load_main').fadeOut();
                                    $('.social_regis').fadeOut();
                                    $('.social_regis_main').fadeOut();
                                }
                                else if(response === 'DONE') {
                                    console.log(response);
                                    $('.container').html('<p>You account has already been activated. See you.</p><p>Team NXTDROP.</p>');
                                    $('.load').fadeOut();
                                    $('.load_main').fadeOut();
                                    $('.social_regis').fadeOut();
                                    $('.social_regis_main').fadeOut();
                                }
                                else {
                                    $('.container').html('<p>There was an error. Try Later!</p></br><p>We are sorry for the inconvenience.</p><p>Team NXTDROP.</p>');
                                    $('.load').fadeOut();
                                    $('.load_main').fadeOut();
                                    $('.social_regis').fadeOut();
                                    $('.social_regis_main').fadeOut();
                                }
                            },
                            error: function(response) {
                                $('.container').html('<p>There was an error. Try Later!</p></br><p>We are sorry for the inconvenience.</p><p>Team NXTDROP.</p>');
                                $('.load').fadeOut();
                                $('.load_main').fadeOut();
                                $('.social_regis').fadeOut();
                                $('.social_regis_main').fadeOut();
                                console.log(response);
                            }   
                        });
                    }
                });
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