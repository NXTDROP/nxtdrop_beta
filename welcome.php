<!DOCTYPE html>
<html lang="EN">
    <head>
        <base href="https://nxtdrop.com/">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie-edge">

        <title>NXTDROP: The Fashion Trade Centre</title>

        <!-- CSS -->
        <link type="text/css" rel="stylesheet" href="ss_welcome.css" />

        <!-- JQUERY LIBRARY -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- BOOTSTRAP LIBRARY -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>

        <!-- Font-Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-126110764-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-126110764-1');
        </script>

        <!-- Google Analytics -->
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-126110764-1', 'auto');
            ga('send', 'pageview');
        </script>
        <!-- End Google Analytics -->
    </head>

    <body>
        <div class="main_container" style="opacity: 0.95;">
            <div style="opacity: 1!important;">
                <script type="text/javascript" src="js/welcome.js"></script>
                <table class="header">
                    <tr>
                        <td style="width: 75%;"><a href="https://nxtdrop.com/"><img src="img/altlogowhite.png" id="logo" alt="NXTDROP, Inc. Logo"></a></td>
                        <td style="width: 25%;text-align: right;"><a href="signin" id="login">Log In</a></td>
                    </tr>
                </table>

                <div class="content">
                    <div id="buy">
                        <i class="fas fa-shopping-cart"></i>
                        <p>Buy a pair today</p>
                    </div>

                    <div id="authentication">
                        <i class="fas fa-check-circle"></i>
                        <p>We authenticate it</p>
                    </div>

                    <div id="delivery">
                        <i class="fas fa-box"></i>
                        <p>You receive it</p>
                    </div>
                </div>

                <h3 style="margin: 25px 0 0 0; text-align: center;">All within 5 business days*</h3>
                
                <p style="text-align: center; margin-top: 4em; font-size: 18px;" id="text-over-btn">Stop Taking L&apos;s and</p>

                <div class="btn-container" style="text-align: center;">
                    <a href="signup" class="cta">Sign Up</a>
                </div>
                <p style="text-align: center; font-size: 10px; margin-bottom: 7em;" id="text-under-btn">Once you sign up, you&apos;ll be able to enter our monthly giveaway. <br> *Orders made from Canada to US could take more than 5 business days to arrive.</p>

                <img src="img/laptop.png" alt="Laptop" class="laptop">
                <img src="img/kk.png" alt="" class="text">

                <footer>
                    <div class="partners">
                        <a href="https://svb.com"><img src="img/svb.png" alt=""></a>
                        <a href="https://fi.co"><img src="img/fi.png" alt=""></a>
                        <a href="https://stripe.com"><img src="img/stripe.png" alt=""></a>
                    </div>
                    <div class="links">
                        <a href="privacy" target="_blank">Privacy</a>
                        <a href="terms" target="_blank">Terms</a>
                        <a href="https://stripe.com/us/connect-account/legal" target="_blank">Stripe Agreements</a>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>