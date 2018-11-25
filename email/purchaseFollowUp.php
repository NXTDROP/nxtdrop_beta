<?php
    include '../dbh.php';
    $email = $_GET['email'];
    $getUserInfo = $conn->prepare("SELECT username FROM users WHERE email = ?");
    $getUserInfo->bind_param("s", $email);
    $getUserInfo->execute();
    $getUserInfo->bind_result($username);
    $getUserInfo->fetch();
    $getUserInfo->close();
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <title></title>
        <base href="https://nxtdrop.com/">
        <meta name="description" content="Welcome to NXTDROP">
        <meta name="author" content="NXTDROP, Inc.">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Font-Awesome -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css?family=Archivo+Black|Righteous|Roboto" rel="stylesheet">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>

        <style>
            * {
                padding: 0;
                margin: 0;
                list-style: none;
                -webkit-transition: background-color 0.5s ease-out;
                -moz-transition: background-color 0.5s ease-out;
                -o-transition: background-color 0.5s ease-out;
                transition: background-color 0.5s ease-out;
                -webkit-transition: border-color 0.5s ease-out;
                -moz-transition: border-color 0.5s ease-out;
                -o-transition: border-color 0.5s ease-out;
                transition: border-color 0.5s ease-out;
            }

            html {
                position: relative;
                min-height: 100%;
            }

            body {
                font-family: 'Archive Black', sans-serif;
                background-color: #FAFAFA;
                height: 100%;
                background: #fff;
                color: #fff;
                max-width: 696px;
                margin: auto;   
            }

            .email_container {
                width: 100%;
                margin: auto auto;
            }

            .header {
                background: #bc3838;
                margin: 0;
                padding: 5px;
            }
            
            .content {
                width: 100%;
                background: #fcfcfc;
            }

            #nxtdrop_icon {
                width: 2.2rem;
                margin: 20px auto 20px auto;
            }

            .footer {
                background: #fcfcfc;
                color: #8e8e8e;
                padding: 10px;
            }

            table {
                width: 90%;
                margin: 0px 5%;
            }

            p {
                text-align: center; 
                font-size: 12px; 
                margin: 15px 20px;
            }

            a {
                text-decoration: none;
                color: #8e8e8e;
            }

            a:hover {
                color: #bc3838;
            }

            #signin_btn {
                width: 50%;
                margin: 15px 25%;
                border: 1px solid #bc3838;
                background: #bc3838;
                padding: 5px;
                font-size: 16px;
                color: #fff;
                font-size: 'Archive Black', sans-serif;
                font-weight: 700;
                border-radius: 2px;
            }

            #signin_btn:hover {
                background: tomato;
                border-color: tomato;
                cursor: pointer;
            }

            ol li {
                list-style-type: decimal; 
            }

            .card {
                width: 100%;
            }

            .card img {
                width: 70%;
                margin: 2.5px 15%;
            }
            .card a button {
                width: 60%;
                margin: 2.5px 20%;
                padding: 5px;
                background: #bc3838;
                border: none;
                color: #fff;
                letter-spacing: 2px;
                text-transform: uppercase;
                font-weight: 700;
                cursor: pointer;
                border-radius: 4px;
            }

            .card a button:hover {
                background: tomato;
            }
        </style>
    </head>

    <body>
        <div class="container email_container">
            <div class="header">
                <a href="https://nxtdrop.com"><img src="https://nxtdrop.com/img/nxtdropiconwhite.png" alt="NXTDROP, Inc." id="nxtdrop_icon"></a>

                <h2 style="font-size: 1.5rem; text-align: center; margin: 0 0 10px 0; font-family: Archive Black, sans-serif;">ORDER DELIVERED</h2>

                <p style="text-align: center; font-family: Roboto, sans-serif; margin: 0 0 3px 0; font-size: 0.60rem; font-weight: 500;">Thank you for choosing NXTDROP!</p>
                <p style="text-align: center; font-family: Roboto, sans-serif; margin: 0 0 0 0; font-size: 0.60rem; font-weight: 500;">We hope that you like your order.</p>
            </div>

            <div class="content" style="overflow: hidden;">
                <p style="color: #222222;">Hi <?php echo $username; ?></p>
                <p style="color: #222222;">We got word that you receive your order. We hope that everything is fine. Let us know if you have concerns. Send us an email at <a href="mailto:support@nxtdrop.com">support@nxtdrop.com</a> and we&apos;ll respond in less than 24 hours.</p>
                <h1 style="color: #222222; text-align: center;">Popular this Week</h1>
                <p style="color: #222222; text-align: center;">Check out the most popular sneakers selling on NXTDROP this week! 🔥🔥🔥</p>
                <?php
                    $getMostPopular = $conn->prepare("SELECT products.productID, products.model, products.assetURL FROM products, product_rank WHERE products.productID = product_rank.productID ORDER BY product_rank.rank DESC LIMIT 4;");
                    $getMostPopular->execute();
                    $getMostPopular->bind_result($productID, $model, $assetURL);

                    while($getMostPopular->fetch()) {
                        echo '<div class="card">
                                <img src="'.$assetURL.'" alt="'.$model.'">
                                <p style="color: #222222; text-align: center;">'.$model.'</p>
                                <a href="https://nxtdrop.com/sneakers/'.$productID.'"><button>See Offers</button></a>
                            </div>';
                    }
                ?>
            </div>

            <div class="footer">
                <table style="margin: 0 0 10px 0;">
                    <tr style="font-size: 0.5rem;">
                        <th><a href="https://instagram.com/nxtdrop">INSTAGRAM</a></th>
                        <th><a href="https://twitter.com/nxtdrop">TWITTER</a></th>
                        <th><a href="https://nxtdrop.com/privacy">PRIVACY</a></th>
                        <th><a href="https://nxtdrop.com/terms">TERMS</a></th>
                    </tr>
                </table>
                <p style="font-size: 0.55rem; margin: 2.5px auto; width: 90%; text-align: center;">&copy; NXTDROP, Inc. All rights reserved.</p>
                <p style="font-size: 0.55rem; margin: 2.5px auto; width: 90%; text-align: center;">If you prefer not to receive emails like this from NXTDROP, you may <a href="<?php echo 'https://nxtdrop.com/unsubscribe/'.$email; ?>" style="text-decoration: underline; color: #424242;">unsubscribe</a></p>
            </div>
        </div>
    </body>
</html>