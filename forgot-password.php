<?php 
    include 'dbh.php';
    include('pwd.rec/econfirmation.php');
    session_start();
?>
<!DOCTYPE html>

<html>
    <head>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-546WBVB');</script>
<!-- End Google Tag Manager -->
        <title>
            Forgot Your password - NXTDROP - Canada's #1 Sneaker Marketplace
        </title>
        <base href="https://nxtdrop.com/">
        <link rel="canonical" href="https://nxtdrop.com/forgot_password">
        <link type="text/css" rel="stylesheet" href="forgot-password.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    </head>

    <body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-546WBVB"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
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