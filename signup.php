<?php 
    include 'dbh.php';
    session_start();
?>
<!DOCTYPE html>

<html>
    <title>
    NXTDROP: The Fashion Trade Centre
    </title>
    <head>
       <base href="https://nxtdrop.com/">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="google-signin-client_id" content="257002911489-cpnet2eibl9jo7a10deh20i7qphv5q3a.apps.googleusercontent.com">
        <link type="text/css" rel="stylesheet" href="logstylesheet.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- Font-Awesome -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>
        <script type="text/javascript" src="regis/registration.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <script src="https://apis.google.com/js/api.js"></script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-126110764-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-126110764-1');
        </script>

        <!-- Google Analytics -->
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-126110764-1', 'auto');
            ga('send', 'pageview');
        </script>
        <!-- End Google Analytics -->
    </head>

    <body>
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