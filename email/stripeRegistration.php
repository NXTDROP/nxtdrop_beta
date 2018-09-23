<?php
    if(isset($_GET['email'])) {
        $email = $_GET['email'];
        $uname = $_GET['username'];
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
        <title>Hi <?php echo $uname; ?></title>
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

            .badge {
                background: #aa0000;
                color: #fff;
                padding: 3px;
                border-radius: 8px;
                font-size: 10px;
            }
        </style>
    </head>

    <body>
        <div class="container email_container">
            <div class="header">
                <a href="https://nxtdrop.com"><img src="https://nxtdrop.com/img/nxtdropiconwhite.png" alt="NXTDROP, Inc." id="nxtdrop_icon"></a>

                <h2 style="font-size: 1.5rem; text-align: center; margin: 0 0 10px 0; font-family: Archive Black, sans-serif;">Hi <?php echo $uname; ?></h2>

                <p style="text-align: center; font-family: Roboto, sans-serif; margin: 0 0 3px 0; font-size: 0.85rem; font-weight: 500;">Thank you for creating a NXTDROP account!</p>
                <p style="text-align: center; font-family: Roboto, sans-serif; margin: 0 0 0 0; font-size: 0.85rem; font-weight: 500;">Click the button below to confirm your email, and setup your account.</p>
            </div>

            <div class="content" style="overflow: hidden;">
                <p style="color: #000;">Hi <?php echo $uname; ?>,</p>
                <p style="color: #000;">We partnered with <span class="badge">Stripe, Inc</span> and <span class="badge">Silicon Valley Bank</span> recently to accept payments directly on our platform. Once you confirm your email, you will be able to transfer funds from your NXTDROP account to your Bank Account. In order to set up your account, we are required to collect your personal information to avoid fraudulent activities. All the information you give us will be collected following GDPR regulations. The NXTDROP Team is working hard to make sure your personal information is secure and safe. Thank you again for signing up!</p>
                <p style="color: #000;">It is important that your fill the form in settings. If you want more info about consignment fees, please contact <a href="mailto:momar@nxtdrop.com">momar@nxtdrop.com.</a></p>
                <p style="color: #000;">Sorry for the inconvenience.</p>
                <p style="color: #000;">Team NXTDROP.</p>
                <p style="color: #000;"> <b>Don&apos;t forget to enter our monthly giveaways. You can boost your chances by listing an item for sale.</b></p>
                <a href="<?php echo 'https://nxtdrop.com/stripeActivation/'.$email; ?>"><button id="signin_btn">CONFIRM EMAIL & SETUP ACCOUNT</button></a>
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