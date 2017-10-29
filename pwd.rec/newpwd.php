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
        <link type="text/css" rel="stylesheet" href="../forgot-password.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="newpwd.js"></script>
    </head>

    <body>
        <header>
            <a href="../index.php"><img id ="logo" src="../img/nxtdroplogo.png" width="125px"></a>
        </header>

        <script>
            var email = "<?php echo $_GET['email']; ?>";
            var hash = "<?php echo $_GET['hash']; ?>";
        </script>
        
        <div class="container">
            <form action="" method="POST" class="reset-form" id="signup">
                <input type="password" name="email" placeholder="New Password" required id="pwd"></br>
                <input type="password" name="email" placeholder="Confirm password" required id="cPwd"></br>
                <button type="submit" name="submit" id="submit">Reset Password</button>
                <p id="form-message"></p>
            </form>
        </div>
    </body>
</html>