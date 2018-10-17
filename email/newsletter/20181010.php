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
        <title></title>
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
                width: 2.2rem;
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
                font-size: 14px;
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
                font-size: 12px; 
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
                font-size: 12px;
                width: 50%;
                margin: 5px 25%;
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

            #under {
                font-weight: 700;
            }
        </style>
    </head>

    <body>
        <div class="container email_container">
            <div class="header">
                <a href="https://nxtdrop.com"><img src="https://nxtdrop.com/img/nxtdropiconwhite.png" alt="NXTDROP, Inc." id="nxtdrop_icon"></a>

                <h2 style="font-size: 1.5rem; text-align: center; margin: 0 0 10px 0; font-family: Archive Black, sans-serif;">Daniel Arsham&apos;s collab with adidas droppping this week!</h2>
                <p style="text-align: center; font-family: Roboto, sans-serif; margin: 0 0 5px 0; font-size: 1.2rem; font-weight: 500;">&#x1F525 OR &#x2744?</p>
            </div>

            <div class="content">
                <p>The artist Daniel Arsham collaborated with adidas to release his own version of the Futurecraft 4D. Like the Futurecraft "Aero Green", the 4D has the same green color. The shoes also have hidden details that appears when exposed to UV Light. The collab is set to release October 12th at a retail price of $450. &#x1F605</p>
                <img src="https://nxtdrop.com/emailAsset/arsham4d.jpg" alt="Daniel Arsham x adidas Futurecraft 4D">
                <p>Colorway: Aero Green</p>
                <p>OFF-WHITE x Converse Chuck 70 released October 8th. Hope you had a chance to get your hands on them. If you didn&apos;t, they&apos;ll soon be up for sale on NXTDROP.</p>
                <img src="https://nxtdrop.com/emailAsset/offwhiteconverse.jpg" alt="NikexOFF-WHITE Blazer Mid Grim Reaper">
                <p>Colorway: White/Bold Orange-Black</p>
                <p>Hypefest by HYPEBEAST occured last week-end and a lot of designers, brands and celebrities were present at the event. Nike displayed a new pair of Air Force 1 High in collaboration with ALYX Studio in all-black and all-white colorway. The cool thing about it is ALYX Studio&apos;s signature buckle at the ankle strap. Unfortunately, there is no release date yet, but stay tuned.</p>
                <img src="https://nxtdrop.com/emailAsset/alyxaf1.jpg" alt="NikexOFF-WHITE Blazer Mid Grim Reaper">
                <p>Colorway: White</p>
                <h4>&#x1F525 Popular this week:</h4>
                <a href="https://nxtdrop.com/sneakers/1000007"><p>adidas YEEZY Boost 350 Cream White</p></a>
                <a href="https://nxtdrop.com/sneakers/1000275"><p>adidas Ultra Boost 2.0 White Reflective</p></a>
                <a href="https://nxtdrop.com/sneakers/1000070"><p>Nike Air Presto Mid Acronym Dynamic Yellow</p></a>
                <a href="https://nxtdrop.com/sneakers/1000028"><p>Air Jordan 4 Retro Raptors</p></a>
                <p style="font-family: 'Gloria Hallelujah', cursive;">The NXTDROP Team.</p>
                <p style="font-family: 'Gloria Hallelujah', cursive;">TAKE CARE!</p>
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