<?php 
    include 'dbh.php';
    session_start();
?>
<!DOCTYPE html>

<html>
    <title>
        Sign Up - NXTDROP - Canada's #1 Sneaker Marketplace
    </title>
    <head>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-546WBVB');</script>
<!-- End Google Tag Manager -->
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
 fbq('init', '1908028209510021'); 
fbq('track', 'PageView');
</script>
<noscript>
 <img height="1" width="1" 
src="https://www.facebook.com/tr?id=1908028209510021&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->
        <?php
            if($_SERVER['SERVER_NAME'] === 'localhost') {
                $base = 'https://localhost/nd-v1.00/';
            } else {
                $base = 'https://nxtdrop.com/';
            }
        ?>
        <base href="<?php echo $base; ?>">
        <link rel="canonical" href="https://nxtdrop.com/signup" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
        <meta name="google-signin-client_id" content="257002911489-cpnet2eibl9jo7a10deh20i7qphv5q3a.apps.googleusercontent.com">
        <link type="text/css" rel="stylesheet" href="logstylesheet.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- Font-Awesome -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>
        <script type="text/javascript" src="regis/registration.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <script src="https://apis.google.com/js/api.js"></script>
    </head>

    <body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-546WBVB"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
        <script>
            //FACEBOOK SIGN UP 
            window.fbAsyncInit = function() {
                FB.init({
                    appId      : '316718239101883',
                    cookie     : true,
                    xfbml      : true,
                    version    : 'v3.1'
                });  
            };

            // Load the SDK asynchronously
            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "https://connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));

            function fb_signup() {
                FB.login(function(response){
                    console.log(response);
                    // The response object is returned with a status field that lets the
                    // app know the current login status of the person.
                    if (response.status === 'connected') {
                        // Logged into your app and Facebook.
                        getInfo();
                        $('#social_regis_title').html('Sign up with Facebook');
                        $('.social_regis').fadeIn();
                        $('.social_regis_main').show();
                    } 
                    else if(response.status === 'not_authorized') {
                        //Person is not autorized to access app
                        $('#form-message').html('Not authorized. Create an account via email.').css('color', 'red');
                        console.log("not_autorized");
                    }
                    else {
                        // The person is not logged into your app or we are unable to tell.
                        $('#form-message').html('We have a problem. Create an account via email.').css('color', 'red');
                        console.log("not logged in");
                    }
                }, {scope: 'email, public_profile'});
            }

            function getInfo() {
                FB.api('/me', 'GET', {fields: 'name, picture, email'}, function(response) {
                    name = response.name;
                    email = response.email;
                    console.log(response);
                });
            }

            //GOOGLE SIGN UP
            var googleUser = {};
            gapi.load('auth2', function() {
                auth2 = gapi.auth2.init();
            });
            function g_signup() {
                auth2.signIn().then(function (googleUser) {
                    if(typeof googleUser === "object") {
                        name = googleUser.getBasicProfile().getName();
                        email = googleUser.getBasicProfile().getEmail();
                        $('#social_regis_title').html('Sign up with Google');
                        $('.social_regis').fadeIn();
                        $('.social_regis_main').show();
                    }
                }, function(error) {
                    console.log(error);
                });
            }
        </script>
        <header>
            <a href="home"><img id ="logo" src="img/nxtdroplogo.png" width="125px"></a>
        </header>

        <p style="font-size: 20px; color: #222222; text-align: center; margin-bottom: 10px;">Have an account?<a href="signin" style="text-decoration: none; color: tomato;" onClick="ga('send', 'event', 'button', 'click', 'SignUpBtn LP');"> Login »</a></p>
        
        <div class="form-container">
            <button class="fb_login" onClick="fb_signup();"><i class="fab fa-facebook"></i> Sign Up with Facebook</button>
            <button class="google_login" onClick="g_signup();"><img src="img/google.png" alt="Google, Inc." style="width: 18px; margin-bottom: -2px; background: #fff; padding: 0px;"> Sign Up with Google</button>
            <form action="" method="POST" id="signup" class="signup-form">   
                <p style="color: #8e8989;">or, sign up with email</p>
                <input type="text" name="name" id="name" placeholder="Name"><br>
                <input type="text" name="email" id="email" placeholder="Email [Required]"><br>
                <input type="text" name="username" id="username" placeholder="Username [Required]"><br>
                <input type="password" name="pwd" id="pwd" placeholder="Password [Required]"><br>
                <input type="password" name="cpwd" id="cpwd" placeholder="Confirm Password [Required]"><br>
                <select class="country_select">
                    <option selected>Select Country [REQUIRED]</option>
                    <option value="CA">CANADA</option>
                    <option value="US">UNITED STATES</option>
                </select>
                <input type="text" name="invite" id="invite_code" placeholder="Have an invite code?"><br>
                <button type="submit" name="submit" id="submit">Create Account</button><br>
                <p id="agreement" style="margin-top: 10px;">By creating an account, you agree to our <a href="terms" target="_blank">Terms of Use</a>, <a href="privacy" target="_blank">Privacy Policy</a> and the <a href="https://stripe.com/us/connect-account/legal" target="_blank">Stripe Connected Account Agreement</a>.<p>
                <p id="form-message" style="font-size: 13px; font-weight: 500;"></p>
            </form action="" method="POST">
        </div>
        <?php include('regis/modalRegistration.php') ?>
        <?php include('regis/social_regis.php') ?>
    </body>
</html>