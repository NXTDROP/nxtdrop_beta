<?php 
    include 'dbh.php';
?>

<DOCTYPE html>

<html lang="en-US">

    <head>
        <link rel="stylesheet" type="text/css" href="../stylesheet.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="newpwd.js"></script>
    </head>

    <body>
        <div class="header">
            <h1><a href="index.php">HOME</a></h1>
        </div>

        <script>
            var email = "<?php echo $_GET['email']; ?>";
            var hash = "<?php echo $_GET['hash']; ?>";
        </script>

        <form class="signup-form" action="" method="POST" id="signup">
            <input type="password" name="pwd" placeholder="Enter Password" id="pwd">
            <input type="password" name="cPwd" placeholder="Confirm Password" id="cPwd">
            <button type="submit" name="submit" id="submit">Update</button>
            <p id="form-message"></p>
        </form>
    </body>

</html>