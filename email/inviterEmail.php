<?php
    
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Invite a friend and get $40 off</title>
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
                font-size: 20px;
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
        </style>
    </head>

    <body>
        <div class="container email_container">
            <div class="header">
                <a href="https://nxtdrop.com"><img src="https://nxtdrop.com/img/nxtdropiconwhite.png" alt="NXTDROP, Inc." id="nxtdrop_icon"></a>
            </div>

            <div class="content" style="overflow: hidden; color: #555555;">
                <p style="text-align: center; font-size: 20px; font-weight: 400;">XXX, Thank you for trusting and purchasing from us. At Nxtdrop, we are striving to put a smile on our loyal customers. We are giving you an opportunity to <b>get $40 off your next purchase</b> by giving a friend $40 on their first Nxtdrop purchase of $200 or more.</p>
                <a href="https://localhost/nd-v1.00/inviteFriend.php?email="><button id="signin_btn">Invite a friend and get $40 off</button></a>
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
            </div>
        </div>
    </body>
</html>