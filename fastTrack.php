<?php 
    session_start();
    include 'dbh.php';
    $db = 'dbh.php';
    require_once('login/rememberMe.php');
    require_once('inc/currencyConversion.php');

    if($_SESSION['uid'] != 1000000 || $_SESSION['uid'] != 1000002) {

    }

    if(!isset($_SESSION['uid']) && isset($_SESSION['last_visit']) && (time() - $_SESSION['last_visit'] > 600)) {
        session_unset();
        session_destroy();
    }
?>
<!DOCTYPE html>
<html>
    <title>
        NXTDROP Shipment Tracker
    </title>
    <head>
        <?php include('inc/head.php'); ?>
        <link rel="canonical" href="https://nxtdrop.com" />
        <meta name="google-site-verification" content="gtQha3Cxmccl9OP-yqL0bohCuLMM5TbHK9eh0rUeVzU" />
        <!-- Javasripts -->
        <script type="text/javascript">
            $(document).ready(function() {
                checkTalk();
            });

            function checkTalk() {
                $.ajax({
                    url: 'inc/talk/checkTalk.php',
                    type: 'POST',
                    success: function(response) {
                        console.log(response);
                        if(jsonObject = JSON.parse(response)) {
                            var count = jsonObject[0]['count'];
                            if(count > 0) {
                                console.log(jsonObject[0]['timestamp']);
                                $('.talk-header > h2').html(count + ' New messages (tap to see)');
                                $('.talk-popup').addClass('glow');
                                setTimeout(() => {  
                                    checkTalk();
                                }, 10000);
                            } else {
                                $('.talk-header > h2').html('NXTDROP CHAT');
                                $('.talk-popup').removeClass('glow');
                                setTimeout(() => {  
                                    checkTalk();
                                }, 10000);
                            }
                        } else {
                            setTimeout(() => {  
                                checkTalk();
                            }, 5000);
                        }
                    },
                    error: function(response) {
                        setTimeout(() => {  
                            checkTalk();
                        }, 5000);
                    }   
                });
            }
        </script>
    </head>

    <body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-546WBVB"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
        <?php include('inc/navbar/navbar.php'); ?>

        <div class="transaction-stats">
            <table>
                <tr>
                    <th>Pending</th>
                    <th>Cancelled</th>
                    <th>Total</th>
                </tr>
            </table>
        </div>

        <div class="transaction-lists">

        </div>

        <?php require_once('inc/footer.php'); ?>
        <?php include('inc/notificationPopUp/sellerConfirmation.php') ?>
        <?php include('inc/notificationPopUp/MM_verification.php') ?>

    </body>
</html>