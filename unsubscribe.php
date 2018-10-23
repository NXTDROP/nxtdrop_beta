<?php 
    include 'dbh.php';
    session_start();
?>
<!DOCTYPE html>

<html>
    <title>
        Email Subscription - NXTDROP - Canada's #1 Sneaker Marketplace
    </title>
    <head>
        <base href="https://nxtdrop.com/">
        <link type="text/css" rel="stylesheet" href="unsubscribe.css" />
        <meta name="description" content="The safest way to buy and sell sneakers in Canada. All sneakers are guaranteed authentic. Browse brands like Adidas, Yeezy, Nike, Air Jordans, Off-White, NMDs, Supreme, and Bape.">
        <meta name="keywords" content="nxtdrop, next drop, nxt drop, sneaker, adidas, streetwear, nike, nmd, air jordan, sneakers, deadstock, resell, hypebeast">
        <meta name="robots" content="index, follow">
        <meta name="google" content="notranslate">
        <meta name="language" content="english">
        <meta name="twitter:card" value="summary" />
        <meta name="twitter:site" content="@nxtdrop" />
        <meta name="twitter:title" content="NXTDROP - Canada's #1 Sneaker Marketplace: Buy and Sell Authentic Sneakers" />
        <meta name="twitter:description" content="The safest way to buy and sell sneakers in Canada. All sneakers are guaranteed authentic. Browse brands like Adidas, Yeezy, Nike, Air Jordans, Off-White, NMDs, Supreme, and Bape." />
        <meta name="twitter:creator" content="@nxtdrop" />
        <meta name="twitter:image" content="/img/nxtdroplogo.png" />
        <meta name="twitter:image:alt" content="NXTDROP" />
        <meta property="og:title" content="NXTDROP - Canada's #1 Sneaker Marketplace: Buy and Sell Authentic Sneakers" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="www.nxtdrop.com" />
        <meta property="og:image" content="/img/nxtdroplogo.png" />
        <meta property="og:description" content="The safest way to buy and sell sneakers in Canada. All sneakers are guaranteed authentic. Browse brands like Adidas, Yeezy, Nike, Air Jordans, Off-White, NMDs, Supreme, and Bape." />
        <meta property="og:site_name" content="NXTDROP" />
        <meta http-equiv="Content-Language" content="en">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    </head>

    <body>
        <header>
            <a href="home"><img id ="logo"src="img/nxtdroplogo.png" width="125px"></a>
        </header>
        
        <div class="container">
            <?php
                if (!isset($_GET['email'])) {
                    echo '<p>There was an error. Try Later!</p></br>';
                    echo '<p>We are sorry for the inconvenience.</p>';
                    echo '<p>Team NXTDROP.</p>';
                }
                else {
                    $email = $_GET['email'];
                    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
                    $count = mysqli_num_rows($result);
                    if ($count < 1) {
                        echo '<p>There was an error. Try Later!</p></br>';
                        echo '<p>We are sorry for the inconvenience.</p>';
                        echo '<p>Team NXTDROP.</p>';
                    }
                    else {
                        $data = $result->fetch_assoc();
                        if($data['newsletter'] === '0') {
                            echo '<p>You unsubscribe already. If you are still receiving emails from us. Contact us at support@nxtdrop.com</p></br>';
                            echo '<p>We are sorry for the inconvenience.</p>';
                            echo '<p>Team NXTDROP.</p>';
                        } else {
                            $q = "UPDATE users SET newsletter='0' WHERE email='$email';";
                            if (mysqli_query($conn, $q)) {
                                echo '<p>The email <span class="mail">'. $_GET['email'].'</span> has been removed from our newsletter.</p>';
                                echo '<p>Sad to see you go.</p></br>';
                                echo '<p>Hope to see you soon at NXTDROP.</p>';
                                echo '<p>Team NXTDROP</p>';
                            }
                            else {
                                echo '<p>There was an error. Try Later!</p></br>';
                                echo '<p>We are sorry for the inconvenience.</p>';
                                echo '<p>Team NXTDROP.</p>'; 
                            }
                        }
                    }
                }
            ?>
        </div>
    </body>
</html>