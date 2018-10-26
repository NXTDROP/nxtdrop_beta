<?php 
    include 'dbh.php';
    session_start();
    $email = $_GET['email'];
    $checkCountry = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if(mysqli_num_rows($checkCountry) > 0) {
        $data = $checkCountry->fetch_assoc();
        if($data['country'] != '') {
            $countryKnown = true;
            $country = $data['country'];
        } else {
            $countryKnown = false;
            $country = '';
        }
    } else {
        header("Location: nxtdrop.com");
        exit();
    }
?>
<!DOCTYPE html>

<html>
    <head>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-546WBVB');</script>
<!-- End Google Tag Manager -->
        <title>
            NXTDROP - Canada's #1 Sneaker Marketplace
        </title>
        <base href="https://nxtdrop.com/">
        <link rel="canonical" href="https://nxtdrop.com/registration.php">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="The safest way to buy and sell sneakers in Canada. All sneakers are guaranteed authentic. Browse brands like Adidas, Yeezy, Nike, Air Jordans, Off-White, NMDs, Supreme, and Bape." />
        <meta name="keywords" content="nxtdrop, next drop, nxt drop, sneaker, adidas, streetwear, nike, nmd, air jordan, sneakers, deadstock, resell, hypebeast" />
        <meta name="robots" content="noodp, noydir, index, follow, archive" />
        <meta name="google" content="notranslate" />
        <meta name="language" content="english" />
        <meta name="twitter:card" value="summary" />
        <meta name="twitter:site" content="@nxtdrop" />
        <meta name="twitter:title" content="NXTDROP - Canada's #1 Sneaker Marketplace: Buy and Sell Authentic Sneakers" />
        <meta name="twitter:description" content="The safest way to buy and sell sneakers in Canada. All sneakers are guaranteed authentic. Browse brands like Adidas, Yeezy, Nike, Air Jordans, Off-White, NMDs, Supreme, and Bape." />
        <meta name="twitter:creator" content="@nxtdrop" />
        <meta name="twitter:image" content="/img/nxtdroplogo.png" />
        <meta name="twitter:image:alt" content="NXTDROP" />
        <meta property="og:title" content="NXTDROP - Canada's #1 Sneaker Marketplace: Buy and Sell Authentic Sneakers" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="www.nxtdrop.com" />
        <meta property="og:image" content="/img/nxtdroplogo.png" />
        <meta property="og:description" content="The safest way to buy and sell sneakers in Canada. All sneakers are guaranteed authentic. Browse brands like Adidas, Yeezy, Nike, Air Jordans, Off-White, NMDs, Supreme, and Bape." />
        <meta property="og:site_name" content="NXTDROP" />
        <meta http-equiv="Content-Language" content="en" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link type="text/css" rel="stylesheet" href="logstylesheet.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- Font-Awesome -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
        <script type="text/javascript">
            $(document).ready(function() {
                var email = <?php echo $_GET['email']; ?>;
                var country = <?php echo $countr; ?>;
                var countryKnown = <?php echo $countryKnown; ?>;

                if(countryKnown === true) {
                    $.ajax({
                        url: 'paymentRegistration.php',
                        type: 'POST',
                        data: {country: country, email: email},
                        success: function(response) {
                            if(response ===  'DB') {
                                $('#form-message').html('Sorry, we had a problem. Try later or contact us at support@nxtdrop.com');
                            } else if(response === '') {
                                $('#form-message').html('Thank you for updating your account. Hope to see you soon!');
                            } else {
                                $('#form-message').html('Sorry, we had a problem. Try later or contact us at support@nxtdrop.com');
                            }
                        },
                        error: function() {
                            $('#form-message').html('Sorry, we had a problem. Try later or contact us at support@nxtdrop.com');
                        }
                    });
                }

                $('#submit').click(function() {
                    country = $('.country_select').val();
                    $.ajax({
                        url: 'paymentRegistration.php',
                        type: 'POST',
                        data: {country: country, email: email},
                        success: function(response) {
                            if(response ===  'DB') {
                                $('#form-message').html('Sorry, we had a problem. Try later or contact us at support@nxtdrop.com');
                            } else if(response === '') {
                                $('#form-message').html('Thank you for updating your account. Hope to see you soon!');
                            } else {
                                $('#form-message').html('Sorry, we had a problem. Try later or contact us at support@nxtdrop.com');
                            }
                        },
                        error: function() {
                            $('#form-message').html('Sorry, we had a problem. Try later or contact us at support@nxtdrop.com');
                        }
                    });
                });
            });
        </script>
    </head>

    <body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-546WBVB"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
        </script>
        <header>
            <a href="home"><img id ="logo" src="img/nxtdroplogo.png" width="125px"></a>
        </header>
        
        <div class="form-container" style="margin-top: 150px">
            <select class="country_select">
                <option selected>Select Country [REQUIRED]</option>
                <option value="CA">CANADA</option>
                <option value="US">UNITED STATES</option>
            </select>
            <button type="submit" name="submit" id="submit">Update Account</button><br>
            <p id="agreement" style="margin: 10px 12.5%; width: 75%; text-align: center;">By creating an account, you agree to our <a href="terms" target="_blank">Terms of Use</a>, <a href="privacy" target="_blank">Privacy Policy</a> and the <a href="https://stripe.com/us/connect-account/legal" target="_blank">Stripe Connected Account Agreement</a>.<p>
            <p id="form-message" style="font-size: 13px; font-weight: 500;"></p>
        </div>
    </body>
</html>