<?php include 'dbh.php'; session_start(); $error = false; ?>
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
        <form action="" method="POST">
            <p>Username: </p><input type="text" name="username" placeholder="Username">
            <p>Password: </p><input type="password" name="pwd" placeholder="Password">
        </form>
        <div><?php include('login/error.php'); ?></div>
        <form action="" method="POST" id="signup">
            <p>Don't have an account?</p>
            <p>First Name: </p><input type="text" name="fname" id="fname" placeholder="First Name">
            <p>Last Name: </p><input type="text" name="lname" id="lname" placeholder="Last Name">
            <p>Email: </p><input type="text" name="email" id="email" placeholder="Email">
            <p>Username: </p><input type="text" name="username" id="username" placeholder="Username">
            <p>Password: </p><input type="password" name="pwd" id="pwd" placeholder="Password">
            <p>Confirm Password: </p><input type="password" name="cpwd" id="cpwd" placeholder="Confirm Password">
            <button type="submit" name="submit" id="submit">Sign Up</button>
            <p id="form-message"></p>
        </form>
    </body>
</html>