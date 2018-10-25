<?php 
    include 'dbh.php';
    session_start();
?>
<!DOCTYPE html>

<html>
    <title>
        Login - NXTDROP - Canada's #1 Sneaker Marketplace
    </title>
    <head>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-546WBVB');</script>
<!-- End Google Tag Manager -->
        <?php
            if($_SERVER['SERVER_NAME'] === 'localhost') {
                $base = 'https://localhost/nd-v1.00/';
            } else {
                $base = 'https://nxtdrop.com/';
            }
        ?>
        <base href="<?php echo $base; ?>">
        <link rel="canonical" href="https://nxtdrop.com/signin" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="The safest way to buy and sell sneakers in Canada. All sneakers are guaranteed authentic. Browse brands like Adidas, Yeezy, Nike, Air Jordans, Off-White, NMDs, Supreme, and Bape." />
        <meta name="keywords" content="nxtdrop, next drop, nxt drop, sneaker, adidas, streetwear, nike, nmd, air jordan, sneakers, deadstock, resell, hypebeast" />
        <meta name="robots" content="index, follow" />
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
            //FB LOGIN
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

            var email;
$(document).ready(function() {
    $('#submit_login').click(function() {
        var username = $('input[name="username"]').val();
        var pwd = $('input[name="pwd"]').val();
        $.ajax({
            type: 'POST',
            url: 'login/login.php',
            data: {username: username, pwd: pwd},
            success: function(data) {
                if (data == '') {
                    window.location.replace('home');
                } else if(data === 'preferences') {
                    window.location.replace('preferences');
                }
                else if(data === 'redirect') {
                    window.location.href = <?php 
                            if(isset($_SESSION['rdURL'])) {
                                echo "'".$_SESSION['rdURL']."'";
                            } else {
                                echo "'".'home'."'";
                            }
                         ?>;
                }
                else {
                    $('.error_login').html(data).css('color', 'red');
                }
            }
        });
    });

    $('input[name="username"]').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            var username = $('input[name="username"]').val();
            var pwd = $('input[name="pwd"]').val();
            $.ajax({
                type: 'POST',
                url: 'login/login.php',
                data: {username: username, pwd: pwd},
                success: function(data) {
                    if (data == '') {
                        window.location.replace('home');
                    } else if(data === 'preferences') {
                        window.location.replace('preferences');
                    }
                    else if(data === 'redirect') {
                        window.location.href = <?php 
                            if(isset($_SESSION['rdURL'])) {
                                echo "'".$_SESSION['rdURL']."'";
                            } else {
                                echo "'".'home'."'";
                            }
                         ?>;
                    }
                    else {
                        $('.error_login').html(data).css('color', 'red');
                    }
                }
            });
        }
    });

    $('input[name="pwd"]').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            var username = $('input[name="username"]').val();
            var pwd = $('input[name="pwd"]').val();
            $.ajax({
                type: 'POST',
                url: 'login/login.php',
                data: {username: username, pwd: pwd},
                success: function(data) {
                    if (data == '') {
                        window.location.replace('home');
                    } else if(data === 'preferences') {
                        window.location.replace('preferences');
                    }
                    else if(data === 'redirect') {
                        window.location.href = <?php 
                            if(isset($_SESSION['rdURL'])) {
                                echo "'".$_SESSION['rdURL']."'";
                            } else {
                                echo "'".'home'."'";
                            }
                         ?>;
                    }
                    else {
                        $('.error_login').html(data).css('color', 'red');
                    }
                }
            });
        }
    });
});

            function fb_login() {
                FB.login(function(response){
                    console.log(response);
                    // The response object is returned with a status field that lets the
                    // app know the current login status of the person.
                    if (response.status === 'connected') {
                        // Logged into your app and Facebook.
                        $('.login').fadeIn();
                        $('.login_main').show();
                        getEmail();
                        setTimeout(function() {
                            $.ajax({
                                url: 'login/loginViaSM.php',
                                type: 'POST',
                                data: {email: email},
                                success: function(response) {
                                    if (response == '') {
                                        window.location.replace('home'); 
                                    } else if(response === 'preferences') {
                                        window.location.replace('preferences');
                                    }
                                    else if (response === 'ACCOUNT') {
                                        $('.error_login').html('You must create an account to log in.').css('color', 'red');
                                        $('.login').fadeOut();
                                        $('.login_main').fadeOut();  
                                    } 
                                    else if (response === 'DB') {
                                        $('.error_login').html('Cannot connect to server. Try again.').css('color', 'red');
                                        $('.login').fadeOut();
                                        $('.login_main').fadeOut();  
                                    }
                                    else if(response === 'redirect') {
                                        window.location.href = <?php 
                                            if(isset($_SESSION['rdURL'])) {
                                                echo "'".$_SESSION['rdURL']."'";
                                            } else {
                                                echo "'".'home'."'";
                                            }
                                        ?>;
                                    }
                                    else {
                                        $('.error_login').html(response).css('color', 'red');
                                        window.location.replace('home');
                                    }
                                }, 
                                error: function(response) {
                                    $('.error_login').html('Error. Try later.').css('color', 'red');
                                }
                            });
                        }, 2000);
                    } 
                    else if(response.status === 'not_authorized') {
                        //Person is not autorized to access app
                        $('.error_login').html('You are not authorized. Contact us at support@nxtdrop.com.').css('color', 'red');
                        console.log("not_autorized");
                    }
                    else {
                        // The person is not logged into your app or we are unable to tell.
                        console.log("not logged in");
                    }
                }, {scope: 'email'});
            }

            function getEmail() {
                FB.api('/me', 'GET', {fields: 'name, picture, email'}, function(response) {
                    email = response.email;
                    console.log(response);
                });
            }

            //GOOGLE LOGIN
            var googleUser = {};
            gapi.load('auth2', function() {
                auth2 = gapi.auth2.init();
            });
            function g_login() {
                auth2.signIn().then(function (googleUser) {
                    if(typeof googleUser === "object") {
                        email = googleUser.getBasicProfile().getEmail();
                        $('.login').fadeIn();
                        $('.login_main').show();
                        setTimeout(function() {
                            $.ajax({
                                url: 'login/loginViaSM.php',
                                type: 'POST',
                                data: {email: email},
                                success: function(response) {
                                    if (response == '') {
                                        window.location.replace('home'); 
                                    } else if(response === 'preferences') {
                                        window.location.replace('preferences');
                                    }
                                    else if (response === 'ACCOUNT') {
                                        $('.error_login').html('You must create an account to log in.').css('color', 'red');
                                        $('.login').fadeOut();
                                        $('.login_main').fadeOut();  
                                    }
                                    else if (response === 'DB') {
                                        $('.error_login').html('Cannot connect to server. Try again.').css('color', 'red');
                                        $('.login').fadeOut();
                                        $('.login_main').fadeOut();  
                                    }
                                    else if(response === 'redirect') {
                                        window.location.href = <?php 
                                            if(isset($_SESSION['rdURL'])) {
                                                echo "'".$_SESSION['rdURL']."'";
                                            } else {
                                                echo "'".'home'."'";
                                            }
                                        ?>;
                                    }
                                    else {
                                        $('.error_login').html(response).css('color', 'red');
                                        window.location.replace('home');
                                    }
                                }, 
                                error: function(response) {
                                    $('.error_login').html('Error. Try later.').css('color', 'red');
                                }
                            });
                        }, 2000);
                    }
                }, function(error) {
                    console.log(error);
                });


            }
        </script>
        <header>
            <a href="home"><img id ="logo" src="img/nxtdroplogo.png" width="125px"></a>
        </header>
        
        <div class="form-container">
            <div class="login-form">
                <button class="fb_login" onClick="fb_login();"><i class="fab fa-facebook"></i> Continue with Facebook</button>
                <button class="google_login" onClick="g_login();"><img src="img/google.png" alt="Google, Inc." style="width: 18px; margin-bottom: -2px; background: #fff; padding: 0px;"> Continue with Google</button>
                <p style="color: #8e8989;">or, login with email</p>
                <input type="text" name="username" placeholder="Username" required><br>
                <input type="password" name="pwd" placeholder="Password" required><br>
                <button type="submit" name="submit" id="submit_login" onClick="ga('send', 'event', 'button', 'click', 'loginBtn');">Login</button><br>
            </div>
            <p class="error_login"></p>
        </div>
        <p style="font-size: 20px; color: #222222; text-align: center;">Don&apos;t have an account? <a href="signup" style="text-decoration: none; color: tomato;" onClick="ga('send', 'event', 'button', 'click', 'SignUpBtn LP');">Sign Up »</a></p>
        <p style="color: tomato; font-size: 16px; text-align: center; margin: 5px 0 0 0;"><a href="forgot_password" style="color: tomato;">Forgot you password?</a></p>
        <?php include('login/modalLogin.php') ?>
    </body>
</html>