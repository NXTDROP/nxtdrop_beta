<?php 
    include 'dbh.php';
    session_start();
?>
<!DOCTYPE html>

<html>
    <title>
    NXTDROP: The Fashion Trade Centre
    </title>
    <head>
        <base href="https://nxtdrop.com/">
        <link type="text/css" rel="stylesheet" href="stylesheet_report.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function() {
                $('.report').on('keydown', function(e){
                    var report = $('.report').val();
                    if (e.keyCode == 13 && report == '') {
                        e.preventDefault();
                        $('.report').val('');
                    }
                    //$(this).val($(this).val().replace(/[\r\n\v]+/g, ''));
                });
                $('#submit').click(function() {
                    var username = $('#username').val();
                    var report = $('.report').val();
                    $('#message').html('');
                    $.ajax({
                        type: 'POST',
                        url: 'inc/send_inquiry.php',
                        data: {username: username, report: report},
                        success: function(data) {
                            if (data == '') {
                                $('#submit').html('Sent!');
                                setTimeout(() => {
                                    $('#submit').html('Send Report');
                                    $('.report').val('');
                                    $('#username').val('');
                                }, 2500);
                            }
                            else {
                                $('#submit').html('Error!');
                                $('#message').html(data);
                                setTimeout(() => {
                                    $('#submit').html('Send Report');
                                }, 2500);
                            }
                        }
                    });
                });
            });
        </script>
    </head>

    <body>
        <script>
            window.fbAsyncInit = function() {
                FB.init({
                appId      : '{your-app-id}',
                cookie     : true,
                xfbml      : true,
                version    : '{api-version}'
                });
                
                FB.AppEvents.logPageView();   
                
            };

            (function(d, s, id){
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement(s); js.id = id;
                js.src = "https://connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        <header>
            <a href="home"><img id ="logo"src="img/nxtdroplogo.png" width="125px"></a>
        </header>
        
        <div class="container">
            <div class="report_form" id="report">
                <input type="text" name="username" placeholder="Enter Username (NXTDROP Users Only)" id="username">
                <textarea class="report" placeholder="What's your concern?" required></textarea></br>
                <button id="submit">Send Report</button>
            </div>
            <br><br>
            <p id="message"></p>
            <a href="home"><p>Cancel</p></a>
        </div>
    </body>
</html>