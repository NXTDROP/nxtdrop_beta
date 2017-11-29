<!DOCTYPE html>
<html>
    <title>
        NXTDROP: The Social Marketplace
    </title>
    <head>
            <link type="text/css" rel="stylesheet" href="messages.css" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
            <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
            <script src="js/messages.js"></script>

    </head>

    <body>
        <?php include('inc/header-body.php'); ?>
                
        <div class="chat_box">
            <div class="chat_head">
                <p>Messages</p>
                <button class="message_button">New Message</button>
            </div>
            <div class="chat_body">
                <div class="user 1">
                    <i class="fa fa-circle" aria-hidden="true"></i>
                    <ul>
                        <li><h2>Teezy</h2></li>
                        <li><p class="last_text 1">Yeah sure man.</p></li>
                    </ul>
                    <p class="time 1">30 s</p>
                </div>

                <!--<div class="user 2">Yusuf
                    <div class="last_text 2">Sup</div>
                    <div class="time 2">1h</div>
                </div>-->
            </div>
        </div>

        <div class="msg_box">
            <div class="msg_head"><p id="from">Teezy</p>
                <div class="close"><i class="fa fa-times" aria-hidden="true" title="Close Chat"></i></div>
            </div>
            <div class="msg_body">
                <div class="msg_a">Yoo! Wanna trade these Yeezy?</div>
                <div class="msg_b">Yeah sure man.</div>
                <div class="msg_insert"></div>
            </div>
            <textarea class="msg_input" placeholder="Enter Message..."></textarea>
        </div>

        <div class="msg_box2">
            <div class="msg_head2">Yusuf
                <div class="close"><i class="fa fa-times" aria-hidden="true" title="Close Chat"></i></div>
            </div>
            <div class="msg_body2">
                <div class="msg_a2">Wassup?</div>
                <div class="msg_b2">Sup</div>
                <div class="msg_insert2"></div>
            </div>
            <textarea class="msg_input2" placeholder="Enter Message..."></textarea>
        </div>

        <section class="footer">
            <ul>
                <li><p>&copy NXTDROP Inc. 2017</p></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Terms &amp Privacy</a></li>
            </ul>
        </section>
                
    </body>
</html>