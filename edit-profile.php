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
        <link type="text/css" rel="stylesheet" href="edit-profile.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    </head>

    <body>
        <header>
            <a href="index.php"><img id ="logo"src="img/nxtdroplogo.png" width="125px"></a>
        </header>
        
        <div class="container">
            <form action="" method="POST" class="login-form">
                <input type="text" name="first_name" placeholder="First Name" required></br>
                <input type="text" name="last_name" placeholder="Last Name" required></br>
                <input type="text" name="email" placeholder="Email" required></br>
                <input type="password" name="pwd" placeholder="@Username" required></br>
                <textarea placeholder="Bio"></textarea></br>
                <button type="submit" name="submit" id="submit">Save Changes</button>
            </form>
</br></br>
            <form action="" method="POST" class="">
            <input type="password" name="pwd" placeholder="Enter New Password" required></br>
            <input type="password" name="cpwd" placeholder="Confirm Password" required></br>
            <button type="submit" name="submit" id="submit">Change Password</button>
            </form>

</br></br>
            <a href="profile.php"><p>Back to Profile</p></a>
        </div>
    </body>
</html>