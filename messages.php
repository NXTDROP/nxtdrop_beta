<?php 
    session_start();
    include "dbh.php";
    include "inc/time.php";

    if (!isset($_SESSION['uid'])) {
        header("Location: login.php");
    }
?>

<!DOCTYPE html>
<html>
    <title>
        NXTDROP: The Social Marketplace
    </title>
    <head>
            <link type="text/css" rel="stylesheet" href="messages.css" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
            <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
            <script src="typeahead.min.js"></script>
            <script type="text/javascript" src="js/menu-dropdown.js"></script>
            <script type="text/javascript" src="js/post-popup.js"></script>
            <script src="js/messages.js"></script>
            <script src="js/msg-popup.js"></script>    

    </head>

    <body>
        <?php include('inc/header-body.php'); ?>
                
        <div class="chat_box">
            <div class="chat_head">
                <p>Inbox</p>
                <button class="message_button">New Message</button>
            </div>
            <div class="chat_body">
                <div class="user" onclick="show(msg1);">
                    <i class="fa fa-circle" aria-hidden="true"></i>
                    <ul>
                        <li><h2>Teezy</h2></li>
                        <li><p class="last_text">Yeah sure man.</p></li>
                    </ul>
                    <p class="time">30s</p>
                </div>

                <div class="user" onclick="show(msg2);">
                    <i class="fa fa-circle" aria-hidden="true"></i>
                    <ul>
                        <li><h2>Yusuf</h2></li>
                        <li><p class="last_text">Sup</p></li>
                    </ul>
                    <div class="time">1h</div>
                </div>
            </div>
        </div>

        <div class="msg_box" id="msg1">
            <div class="msg_head"><p id="from">Teezy</p>
                <div class="close"><i class="fa fa-times" aria-hidden="true" title="Close Chat"></i></div>
            </div>
            <div class="msg_body" id="body1">
                <div class="msg_a">Yoo! Wanna trade these Yeezy?</div>
                <div class="msg_b">Yeah sure man.</div>
                <div class="msg_insert1"></div>
            </div>
            <textarea class="msg_input" id="1" placeholder="Enter Message..."></textarea>
            <i class="fa fa-paper-plane fa-lg" aria-hidden="true" onclick="send(1)"></i>
        </div>

        <div class="msg_box" id="msg2">
            <div class="msg_head"><p id="from">Yusuf</p>
                <div class="close"><i class="fa fa-times" aria-hidden="true" title="Close Chat"></i></div>
            </div>
            <div class="msg_body" id="body2">
                <div class="msg_a">Wassup?</div>
                <div class="msg_b">Sup</div>
                <div class="msg_insert2"></div>
            </div>
            <textarea class="msg_input" id="2" placeholder="Enter Message..."></textarea>
            <i class="fa fa-paper-plane fa-lg" aria-hidden="true" onclick="send(2)"></i>
        </div>

        <?php include('inc/new-msg.php'); ?>
        <?php include('inc/new-drop-pop.php'); ?>

        <section class="footer">
            <ul>
                <li><p>&copy NXTDROP Inc. 2017</p></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Terms &amp Privacy</a></li>
            </ul>
        </section>
                
    </body>
</html>