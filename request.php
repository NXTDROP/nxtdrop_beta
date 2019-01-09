<?php 
    session_start();
    include "dbh.php";
    $db = 'dbh.php';
    require_once('login/rememberMe.php');
?>
<!DOCTYPE html>
<html>
    <head>
    <?php include('inc/head.php'); ?>
    <title>
        Product Request - NXTDROP - Canada's #1 Sneaker Marketplace
    </title>
    <link rel="canonical" href="https://nxtdrop.com/request" />
        <script type="text/javascript">
            $(document).ready(function() {
                $('#send_request').click(function() {
                    $('#send_request').html('<i class="fas fa-circle-notch fa-spin"></i>');
                    var request = $('#request').val();
                    if(!isEmpty(request) || !isBlank(request)) {
                        $.ajax({
                            url: 'inc/request/sendRequest.php',
                            type: 'POST',
                            data: {request: request},
                            success: function(response){
                                if(response === 'GOOD') {
                                    $('#send_request').html('SENT');
                                    setTimeout(() => {
                                        $('#send_request').html('SEND REQUEST');
                                        $('#request').val('');
                                    }, 2500);
                                } else if(response === 'DB') {
                                    $('#send_request').html('ERROR. TRY LATER.');
                                    setTimeout(() => {
                                        $('#send_request').html('SEND REQUEST');
                                    }, 2500);
                                } else if(response === 'ERROR') {
                                    $('#send_request').html('ERROR. TRY LATER.');
                                    setTimeout(() => {
                                        $('#send_request').html('SEND REQUEST');
                                    }, 2500);
                                }
                            }
                        });
                    } else {
                        $('#send_request').html('Entry is empty.')
                    }
                });
            });

            function isBlank(str) {
                return (!str || /^\s*$/.test(str));
            }

            function isEmpty(str) {
                return (!str || 0 === str.length);
            }
        </script>
    </head>

    <body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-546WBVB"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
        <?php include('inc/navbar/navbar.php'); ?>
        <?php include('inc/drop/new-drop-pop.php'); ?>
        <?php include('inc/search_pop.php') ?>

        <div class="request_container">
            <textarea name="request" id="request" placeholder="Please provide the Brand, Line, Model, Year and Colorway of the item you want to sell (Ex: adidas Yeezy Boost 350 Cream White 2018). Separate with commas if you're requesting many more than 1 pair"></textarea>
            <button id="send_request">SEND REQUEST</button>
        </div>

        <?php require_once('inc/footer.php'); ?>
    </body>
</html>