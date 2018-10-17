<?php 
    include 'dbh.php';
    session_start();
    if(isset($_GET['email']) && $_GET['email'] != '') {
        echo '<script type="text/javascript">var inviterEmail = '."'".$_GET['email']."'".';</script>';
    } else {
        echo '<script type="text/javascript">alert("ERROR.");</script>';
    }
?>
<!DOCTYPE html>

<html>
    <title>
    NXTDROP: The Fashion Trade Centre
    </title>
    <head>
        <!--<base href="https://nxtdrop.com/">-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#submit').click(function() {
                    var friendEmail_One = $('#emailOne').val();
                    var friendEmail_Two = $('#emailTwo').val();
                    if(!isBlank(friendEmail_One) && !isEmpty(friendEmail_One)) {
                        $.ajax({
                            url: 'inc/invite/sendInvite.php',
                            type: 'POST',
                            data: {inviterEmail: inviterEmail, friend_One: friendEmail_One, friend_Two: friendEmail_Two},
                            success: function(response) {
                                if(response === 'DB') {

                                } else if(response === 'ERRROR') {

                                }else if(response === 'NOT USER') {

                                } else if(response === 'ALREADY USER') {

                                } else if(response === 'GOOD') {

                                } else {

                                }
                            }, 
                            error: function(response) {

                            }
                        });
                    } else {
                        alert('Please enter an email address.');
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
        <style>
            header {
                margin: 20px auto;
            }

            header a img {
                display: block;
                margin: 0 auto;
            }

            input {
                width: 70%;
                margin: 10px 15%;
                padding: 8px;
                border: 1px solid #cccccc;
                border-radius: 4px;
                text-align: center;
            }

            button {
                width: 40%;
                margin: 10px 30%;
                padding: 5px;
                border: 1px solid #bc3838;
                border-radius: 4px;
                cursor: pointer;
                background: #bc3838;
                text-transform: uppercase;
                letter-spacing: 2px;
                color: #fff;
            }
        </style>
    </head>

    <body>
        <header>
            <a href="home"><img id ="logo"src="img/nxtdroplogo.png" width="125px" alt="NXTDROP Logo"></a>
        </header>
        
        <div class="container">
            <input type="text" name="email" placeholder="Your friend's email" id="emailOne"><br>
            <input type="text" name="email" placeholder="Bless another friend with an invite" id="emailTwo"><br>
            <button type="submit" id="submit">Send Invite</button>
        </div>
    </body>
</html>