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
        <!--<base href="https://nxtdrop.com/">-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link type="text/css" rel="stylesheet" href="login.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="regis/registration.js"></script>
        <script type="text/javascript" src="login/login.js"></script>
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
        <header>
            <a href="home"><img id ="logo" src="img/nxtdroplogo.png" width="125px"></a>
        </header>
        
        <div class="container">
            <div action="" method="POST" class="login-form">
                <input type="text" name="username" placeholder="Username" required></br>
                <input type="password" name="pwd" placeholder="Password" required></br>
                <button type="submit" name="submit" id="submit_login">Login</button></br></br>
                <p><a href="forgot_password">Forgot Password?</a></p>
            </div>
            <p class="error_login"></p>
            <form action="" method="POST" id="signup" class="signup-form">
                <p>Don't have an account?</p>
                <input type="text" name="name" id="name" placeholder="Name"></br>
                <input type="text" name="email" id="email" placeholder="Email [Required]" required></br>
                <input type="text" name="username" id="username" placeholder="Username [Required]" required></br>
                <input type="password" name="pwd" id="pwd" placeholder="Password [Required]" required></br>
                <input type="password" name="cpwd" id="cpwd" placeholder="Confirm Password [Required]" required></br>
                <input type="checkbox" name="check" id="check" required>
                <label for="check">Accept <a href="terms" target="_blank">Terms of Use</a> and <a href="privacy" target="_blank">Privacy Policy</a>.</label></br>
                <button type="submit" name="submit" id="submit">Create Account</button></br>
                <p id="form-message"></p>
            </form>
        </div>
    </body>
</html>