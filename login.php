<?php 
    include 'dbh.php';
    session_start();
?>
<!DOCTYPE html>

<html>
    <title>
        NXTDROP: The Social Marketplace
    </title>
    <head>
        <base href="https://nxtdrop.com/">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link type="text/css" rel="stylesheet" href="login.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="regis/registration.js"></script>
        <script type="text/javascript" src="login/login.js"></script>
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
                <input type="text" name="fname" id="fname" placeholder="First Name" required></br>
                <input type="text" name="lname" id="lname" placeholder="Last Name" required></br>
                <input type="text" name="email" id="email" placeholder="Email" required></br>
                <input type="text" name="username" id="username" placeholder="Username" required></br>
                <input type="password" name="pwd" id="pwd" placeholder="Password" required></br>
                <input type="password" name="cpwd" id="cpwd" placeholder="Confirm Password" required></br>
                <input type="checkbox" name="check" id="check" required>
                <label for="check">Accept <a href="terms" target="_blank">Terms of Use</a> and <a href="privacy" target="_blank">Privacy Policy</a>.</label></br>
                <button type="submit" name="submit" id="submit">Create Account</button></br>
                <p id="form-message"></p>
            </form>
        </div>
    </body>
</html>