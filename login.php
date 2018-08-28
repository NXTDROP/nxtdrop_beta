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
        <link type="text/css" rel="stylesheet" href="login.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- Font-Awesome -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>
        <script type="text/javascript" src="regis/registration.js"></script>
        <script type="text/javascript" src="login/login.js"></script>
    </head>

    <body>
        <header>
            <a href="home"><img id ="logo" src="img/nxtdroplogo.png" width="125px"></a>
        </header>
        
        <div class="form-container">
            <div action="" method="POST" class="login-form">
                <input type="text" name="username" placeholder="Username" required><br>
                <input type="password" name="pwd" placeholder="Password" required><br>
                <button type="submit" name="submit" id="submit_login">Login</button><br><br>
                <p><a href="forgot_password">Forgot Password?</a></p>
            </div>
            <p class="error_login"></p>
            <form action="" method="POST" id="signup" class="signup-form">
                <p>Don't have an account?</p>
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
                <input type="text" name="invite" id="invite_code" placeholder="Invite Code [OPTIONAL]"><br>
                <button type="submit" name="submit" id="submit">Create Account</button><br>
                <p id="agreement" style="margin-top: 10px;">By creating an account, you agree to our <a href="terms" target="_blank">Terms of Use</a>, <a href="privacy" target="_blank">Privacy Policy</a> and the <a href="https://stripe.com/us/connect-account/legal" target="_blank">Stripe Connected Account Agreement</a>.<p>
                <p id="form-message"></p>
            </form>
        </div>
        <?php include('regis/modalRegistration.php') ?>
    </body>
</html>