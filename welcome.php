<?php

    require 'vendor/autoload.php';
    $email = new \SendGrid\Mail\Mail(); 
    $email->setFrom("admin@nxtdrop.com", "NXTDROP");
    $email->setSubject("Welcome to NXTDROP.");
    $email->addTo('momarcisse0@gmail.com', 'MOMAR');
    $htmlcontent = '<title>
                        Welcome to NXTDROP.
                    </title>

                    <head>
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|PT+Sans|Roboto+Mono|Roboto+Slab" rel="stylesheet"> 
                        <style>
                            * {
                                -webkit-transition: background-color 0.25s ease-out;
                                -moz-transition: background-color 0.25s ease-out;
                                -o-transition: background-color 0.25s ease-out;
                                transition: background-color 0.25s ease-out;
                            }

                            a {
                                text-decoration: none;
                            }

                            body {
                                margin: 0;
                                padding: 0;
                                font-family: "Segoe UI","Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
                                min-height: 98.77%;
                                background-color: #f4f4f4;
                                color: #fff;
                            }
                            
                            .email_head {
                                width: 100%;
                                padding: 10px 0;
                            }
                            
                            .email_head a img {
                                width: 15%;
                                display: block;
                                margin: auto;
                            }

                            .email_body {
                                width: 75%;
                                background: #fff;
                                margin: 15px auto;
                                border-radius: 4px;
                                padding: 15px;
                                color: #000;
                                text-align: center;
                            }

                            .email_body h1 {
                                font-size: 18px;
                                color: #aa0000;
                                font-weight: 800;
                            }

                            .email_body p {
                                font-size: 13px;
                                color: #000;
                                font-weight: 400;
                            }

                            .email_footer {
                                width: 75%;
                                background: #fff;
                                color: #000;
                                margin: 0 auto;
                                border-radius: 4px;
                                padding: 15px;
                                font-size: 12px;
                            }

                            .email_footer a {
                                color: #0e7bce;
                            }

                            .email_footer p {
                                font-weight: 400;
                            }

                            .email_footer a {
                                font-weight: 400;
                            }

                            hr {
                                width: 50%;
                                color: #fff;
                            }

                            #invite_code {
                                text-align: center;
                                background: #0e7bce;
                                width: 20%;
                                color: #fff;
                                border-radius: 4px;
                                font-size: 18px;
                                margin: 0 auto;
                                padding: 5px 10px;
                                -webkit-transition: background-color 0.25s ease-out;
                                -moz-transition: background-color 0.25s ease-out;
                                -o-transition: background-color 0.25s ease-out;
                                transition: background-color 0.25s ease-out;
                            }

                            #invite_code:hover {
                                cursor: pointer;
                                background: #0591fc;
                            }

                            #greetings {
                                background: #aa0000;
                                color: #fff;
                                padding: 15px;
                                text-align: center;
                            }

                            .ticket {
                                background: #aa0000; 
                                padding: 3px; 
                                text-align: center; 
                                color: #fff; 
                                font-size: 12px;
                                border-radius: 6px;
                            }

                            #login {
                                background: #aa0000;
                                color: #fff;
                                text-align: center;
                                width: 25%;
                                margin: 0 37.5%;
                                padding: 5px;
                                border-radius: 24px;
                                border: 1px solid #aa0000;
                            }
                            
                            #login:hover {
                                background: #fff;
                                color: #aa0000;
                                border: 1px solid #aa0000;
                            }

                            .ticket:hover {
                                background: #d11f1f;
                                cursor: pointer;
                            }

                            ul {
                                list-style: none;
                                text-align: center;
                                padding: 0;
                                margin: 0;
                            }
                            
                            ul li {
                                display: inline-block;
                            }
                            
                            ul li a p {
                                color: #aa0000;
                            }
                            
                            ul li a p:hover {
                                cursor: pointer;
                                text-decoration: underline
                            }

                            .image {
                                width: 35px;
                            }

                            #copy {
                                font-size: 10px;
                                text-align: center;
                                background: #aa0000;
                                color: #fff;
                            }
                        </style>
                    </head>

                    <body>
                        <div class="email_head">
                            <a href="https://nxtdrop.com"><img src="https://nxtdrop.com/img/nxtdroplogo.png" alt="NXTDROP, INC." title="NXTDROP, Inc."></a>
                        </div>
                        <hr>

                        <div class="email_body">
                            <h1>Hi <span class="ticket">'.$name.'</span>,</h1>

                            <p>Welcome to NXTDROP, your trusted marketplace. Thank you for joining our community. Buying, selling and trading sneakers and grails is made faster and secure with NXTDROP. We make sure that all listed items are 100% authentic. You can enter an exclusive raffle every month to win a pair of sneaker. Consignment fees are lifted every two sales until <span class="ticket">Jan. 2019.</span></p>
                            <p style="font-size: 14px; font-weight: 700;">Login to enter this month raffle!</p>
                            <a href="https://nxtdrop.com/login_signup"><p id="login" title="Login To Your Account">LOGIN</p></a><br>
                        </div>

                        <div class="email_footer">
                            <p style="color: #777777">Disclaimer: This e-mail message is an automated notification. Please do not reply to this message.</p>
                            <p>Thanks for creating your account. We hope to see you soon make your first purchase or sale with us.</p>
                            <a href="https://nxtdrop.com">NXTDROP.COM</a>
                            <p>Buy, Sell & Trade Fashion</p>
                            <ul>
                                <li><p><a href="https://www.instagram.com/nxtdrop/"><img class="image" src="https://nxtdrop.com/img/instagram.png" title="Instagram"/></a></p></li>
                                <li><p><a href="https://www.twitter.com/nxtdrop/"><img class="image" src="https://nxtdrop.com/img/twitter.png" title="Twitter"/></a></p></li>
                            </ul>
                                
                            <ul>
                                <li><a href="https://nxtdrop.com/"><p title="Unsusbcribe"> Unsuscribe </p></a></li>
                                <li><a href="https://nxtdrop.com/terms"><p title="Terms of Use"> Terms of Use </p></a></li>
                                <li><a href="https://nxtdrop.com/privacy"><p title="Privacy Policy"> Privacy Policy </p></a></li>
                                <li><a href="https://nxtdrop.com/login_signup"><p title="Login"> Login </p></a></li>
                            </ul>
                            <p id="copy">&copy; 2018 NXTDROP, INC. All rights reserved.</p>
                        </div>
                    </body>';
    $email->addContent("text/html", '<strong>fljfkdsjkfjk</strong>');
    $sendgrid = new \SendGrid('SG.1H0XT1gRTMqzZ-5hwthqjQ.370gQCCDCjrKqjnAjDaT4qrxAwnLjAC0T1MaX6aGk10');
    try {
        $response = $sendgrid->send($email);
        print $response->statusCode() . "\n";
        print_r($response->headers());
        print $response->body() . "\n";
    } catch (Exception $e) {
        echo 'We could not send you an email. We will try again!';
    }
    
?>
<!--<html>
    <title>
        Welcome to NXTDROP.
    </title>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|PT+Sans|Roboto+Mono|Roboto+Slab" rel="stylesheet"> 
        <style>
            * {
                -webkit-transition: background-color 0.25s ease-out;
                -moz-transition: background-color 0.25s ease-out;
                -o-transition: background-color 0.25s ease-out;
                transition: background-color 0.25s ease-out;
            }

            a {
                text-decoration: none;
            }

            body {
                margin: 0;
                padding: 0;
                font-family: "Segoe UI","Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
                min-height: 98.77%;
                background-color: #f4f4f4;
                color: #fff;
            }
            
            .email_head {
                width: 100%;
                padding: 10px 0;
            }
            
            .email_head a img {
                width: 15%;
                display: block;
                margin: auto;
            }

            .email_body {
                width: 75%;
                background: #fff;
                margin: 15px auto;
                border-radius: 4px;
                padding: 15px;
                color: #000;
                text-align: center;
            }

            .email_body h1 {
                font-size: 18px;
                color: #aa0000;
                font-weight: 800;
            }

            .email_body p {
                font-size: 13px;
                color: #000;
                font-weight: 400;
            }

            .email_footer {
                width: 75%;
                background: #fff;
                color: #000;
                margin: 0 auto;
                border-radius: 4px;
                padding: 15px;
                font-size: 12px;
            }

            .email_footer a {
                color: #0e7bce;
            }

            .email_footer p {
                font-weight: 400;
            }

            .email_footer a {
                font-weight: 400;
            }

            hr {
                width: 50%;
                color: #fff;
            }

            #invite_code {
                text-align: center;
                background: #0e7bce;
                width: 20%;
                color: #fff;
                border-radius: 4px;
                font-size: 18px;
                margin: 0 auto;
                padding: 5px 10px;
                -webkit-transition: background-color 0.25s ease-out;
                -moz-transition: background-color 0.25s ease-out;
                -o-transition: background-color 0.25s ease-out;
                transition: background-color 0.25s ease-out;
            }

            #invite_code:hover {
                cursor: pointer;
                background: #0591fc;
            }

            #greetings {
                background: #aa0000;
                color: #fff;
                padding: 15px;
                text-align: center;
            }

            .ticket {
                background: #aa0000; 
                padding: 3px; 
                text-align: center; 
                color: #fff; 
                font-size: 12px;
                border-radius: 6px;
            }

            #login {
                background: #aa0000;
                color: #fff;
                text-align: center;
                width: 25%;
                margin: 0 37.5%;
                padding: 5px;
                border-radius: 24px;
                border: 1px solid #aa0000;
            }
            
            #login:hover {
                background: #fff;
                color: #aa0000;
                border: 1px solid #aa0000;
            }

            .ticket:hover {
                background: #d11f1f;
                cursor: pointer;
            }

            ul {
                list-style: none;
                text-align: center;
                padding: 0;
                margin: 0;
            }
            
            ul li {
                display: inline-block;
            }
            
            ul li a p {
                color: #aa0000;
            }
            
            ul li a p:hover {
                cursor: pointer;
                text-decoration: underline
            }

            .image {
                width: 35px;
            }

            #copy {
                font-size: 10px;
                text-align: center;
                background: #aa0000;
                color: #fff;
            }
        </style>
    </head>

    <body>
        <div class="email_head">
            <a href="https://nxtdrop.com"><img src="https://nxtdrop.com/img/nxtdroplogo.png" alt="NXTDROP, INC." title="NXTDROP, Inc."></a>
        </div>
        <hr>

        <div class="email_body">
            <h1>Hi <span class="ticket">Momar</span>,</h1>

            <p>Welcome to NXTDROP, your trusted marketplace. Thank you for joining our community. Buying, selling and trading sneakers and grails is made faster and secure with NXTDROP. We make sure that all listed items are 100% authentic. You can enter an exclusive raffle every month to win a pair of sneaker. Consignment fees are lifted every two sales until <span class="ticket">Jan. 2019.</span></p>
            <p style="font-size: 14px; font-weight: 700;">Login to enter this month raffle!</p>
            <a href="https://nxtdrop.com/login_signup"><p id="login" title="Login To Your Account">LOGIN</p></a><br>
        </div>

        <div class="email_footer">
            <p style="color: #777777">Disclaimer: This e-mail message is an automated notification. Please do not reply to this message.</p>
            <p>Thanks for creating your account. We hope to see you soon make your first purchase or sale with us.</p>
            <a href="https://nxtdrop.com">NXTDROP.COM</a>
            <p>Buy, Sell & Trade Fashion</p>
            <ul>
                <li><p><a href="https://www.instagram.com/nxtdrop/"><img class="image" src="https://nxtdrop.com/img/instagram.png" title="Instagram"/></a></p></li>
                <li><p><a href="https://www.twitter.com/nxtdrop/"><img class="image" src="https://nxtdrop.com/img/twitter.png" title="Twitter"/></a></p></li>
            </ul>
                
            <ul>
                <li><a href="https://nxtdrop.com/"><p title="Unsusbcribe"> Unsuscribe </p></a></li>
                <li><a href="https://nxtdrop.com/terms"><p title="Terms of Use"> Terms of Use </p></a></li>
                <li><a href="https://nxtdrop.com/privacy"><p title="Privacy Policy"> Privacy Policy </p></a></li>
                <li><a href="https://nxtdrop.com/login_signup"><p title="Login"> Login </p></a></li>
            </ul>
            <p id="copy">&copy; 2018 NXTDROP, INC. All rights reserved.</p>
        </div>
    </body>
</html>-->