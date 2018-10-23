<?php 
    include 'dbh.php';
    include('pwd.rec/econfirmation.php');
    session_start();
?>
<!DOCTYPE html>

<html>
    <title>
        Forgot Your password - NXTDROP - Canada's #1 Sneaker Marketplace
    </title>
    <head>
        <base href="https://nxtdrop.com/">
        <link type="text/css" rel="stylesheet" href="forgot-password.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    </head>

    <body>
        <header>
            <a href="home"><img id ="logo"src="img/nxtdroplogo.png" width="125px"></a>
        </header>
        
        <div class="container">
            <form action="" method="POST" class="reset-form" id="econfirmation">
                <input type="text" name="email" placeholder="Enter E-Mail" required><br>
                <button type="submit" name="submit" id="submit">Send Reset E-mail</button>
            </form>
            <br><br>
            <a href="signin"><p>Cancel</p></a>
            <div> <?php include('pwd.rec/error.php'); ?> </div>
        </div>
    </body>
</html>