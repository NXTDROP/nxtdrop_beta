<?php 
    include 'dbh.php';
    session_start(); 
    $error = false; 
?>
<!DOCTYPE html>

<html>
    <title>
        NXTDROP: The Social Marketplace
    </title>
    <head>
        <link type="text/css" rel="stylesheet" href="login.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="regis/registration.js"></script>
    </head>

    <body>
        <header>
            <a href="index.php"><img id ="logo"src="img/nxtdroplogo.png" width="125px"></a>
        </header>
        
        <div class="container">
            <form action="login/login.php" method="POST" class="login-form">
                <input type="text" name="username" placeholder="Username" required></br>
                <input type="password" name="pwd" placeholder="Password" required></br>
                <button type="submit" name="submit" id="submit">Login</button></br></br>
                <p><a href="forgot-password.php">Forgot Password?</a></p>
            </form>
            <div><?php include('login/error.php'); ?></div>
            <form action="" method="POST" id="signup" class="signup-form">
                <p>Don't have an account?</p>
                <input type="text" name="fname" id="fname" placeholder="First Name" required></br>
                <input type="text" name="lname" id="lname" placeholder="Last Name" required></br>
                <input type="text" name="email" id="email" placeholder="Email" required></br>
                <input type="text" name="username" id="username" placeholder="Username" required></br>
                <input type="password" name="pwd" id="pwd" placeholder="Password" required></br>
                <input type="password" name="cpwd" id="cpwd" placeholder="Confirm Password" required></br>
                <button type="submit" name="submit" id="submit">Create Account</button>
                <p id="form-message"></p>
            </form>
        </div>
    </body>
</html>