<?php
    include '../dbh.php';
    if(isset($_GET['username'])) {
        $username = $_GET['username'];
        $email = $_GET['email'];
        $getInfo = $conn->prepare("SELECT code, type, amount FROM discountCode, users WHERE assignedTo = uid AND username = ? ");
        $getInfo->bind_param('i', $_GET['username']);
        $getInfo->execute();
        $getInfo->bind_result($code, $type, $amount);
        $getInfo->fetch();
    }
    else {
        $email = '';
        $uname = '';
    }
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <base href="https://nxtdrop.com/">
        <title><?php echo $username ?>, your $40 off code is here!</title>
        <meta name="description" content="Welcome to NXTDROP">
        <meta name="author" content="NXTDROP, Inc.">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Font-Awesome -->
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah|Roboto" rel="stylesheet">
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
                font-family: 'Roboto', sans-serif;
                background-color: #FAFAFA;
                height: 100%;
                background: #fff;
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
                width: 2.6rem;
                margin: 20px auto 20px auto;
            }

            .footer {
                background: #fcfcfc;
                color: #8e8e8e;
                padding: 10px;
            }
            
            .header {
                color: #fff;
            }

            .content p {
                font-family: 'Roboto', sans-serif;
                color: #222222;
                font-size: 16px;
                letter-spacing: 1px;
                font-weight: 400;
            }

            .content img {
                width: 80%;
                margin: 5px 10%;
            }

            table {
                width: 90%;
                margin: 0px 5%;
            }

            p {
                text-align: center; 
                font-size: 16px; 
                margin: 15px 20px;
            }

            a {
                text-decoration: none;
                color: #8e8e8e;
            }

            .content a p {
                color: #bc3838;
            }

            a button {
                padding: 10px;
                text-transform: uppercase;
                text-align: center;
                background: #bc3838;
                cursor: pointer;
                border: none;
                color: #fff;
                font-weight: 500;
                letter-spacing: 2px;
                border-radius: 4px;
                font-size: 16px;
                width: 50%;
                margin: 5px 25%;
            }

            #code {
                background: #f2f2f2;
                width: 50%;
                margin: 10px 25%;
                padding: 8px;
                font-style: italic;
            }

            h4 {
                margin-top: 10px;
                margin-left: 10px;
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
                font-size: 'Roboto', sans-serif;
                font-weight: 800;
                border-radius: 2px;
            }

            #signin_btn:hover {
                background: tomato;
                border-color: tomato;
                cursor: pointer;
            }

            .badge {
                background: #aa0000;
                color: #fff;
                padding: 3px;
                border-radius: 8px;
                font-size: 10px;
            }

            #under {
                font-weight: 700;
            }
        </style>
    </head>

    <body>
        <div class="container email_container">
            <div class="header">
                <a href="https://nxtdrop.com"><img src="https://nxtdrop.com/img/nxtdropiconwhite.png" alt="NXTDROP, Inc." id="nxtdrop_icon"></a>

                <h2 style="font-size: 1.5rem; text-align: center; margin: 0 0 10px 0; font-family: Archive Black, sans-serif;"><?php echo $username; ?> your $40 off code is here!</h2>
                <p style="text-align: center; font-family: Roboto, sans-serif; margin: 0 0 5px 0; font-size: 0.85rem; font-weight: 500;">Use the 7-character token when checking out</p>
            </div>

            <div class="content">
                <p>Hey <?php echo $username; ?>, </p>
                <p>You requested $40 off and we got you. Use the code below.</p>
                <p>Your code is: </p>
                <p id="code"><?php echo $code; ?></p>
                <p style="font-family: 'Gloria Hallelujah', cursive;">The NXTDROP Team.</p>
                <p style="font-family: 'Gloria Hallelujah', cursive;">ITS LIT!</p>
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
                <p style="font-size: 0.55rem; margin: 2.5px auto; width: 90%; text-align: center;">You cannot unsubscribe from this type of email for security reasons.</p>
            </div>
        </div>
    </body>
</html>