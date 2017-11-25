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
            <header>
                    <a><img id ="logo"src="img/nxtdroplogo.png" height="20px"></a>
                    <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i></a>
                        
                    <?php
                        if(isset($_SESSION['uid'])) {
                            echo '<a href="likes.php"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                            <a href="profile.php"><i class="fa fa-user" aria-hidden="true"></i></a>';
                        }
                        else {
                            echo '<a href="login.php"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                            <a href="login.php"><i class="fa fa-user" aria-hidden="true"></i></a>';
                        }
                    ?>
                    <div class="search-bar">
                        <form action="search.php" method="GET" id="search-bar">
                        <input type="text" name="q" size="60" placeholder="Search" />
                        </form>
                    </div>
                    <?php
                        if(isset($_SESSION['uid'])) {
                            echo '<button class="call_post">New Drop</button>
                            <div class="dropdown"><i onclick="more()" class="fa fa-ellipsis-h" aria-hidden="true" id="dropbtn"></i><div id="myDropdown" class="dropdown-content"><a href="login/logout.php">Log Out</a></div></div>';
                        }
                        else {
                            echo '<a href="login.php"><button class="login-button">Sign Up/Login</button></a>';
                        }
                    ?>
                </header>
                
                <div class="chat_box">
                    <div class="chat_head">Messages</div>
                        <div class="chat_body">
                            <div class="user">Teezy</div>
                            <div class="user2">Yusuf</div>
                        </div>
                </div>

                <div class="msg_box">
                    <div class="msg_head">Teezy
                        <div class="close">X</div>
                    </div>
                    <div class="msg_body">
                        <div class="msg_a">Yoo! Wanna trade these Yeezy?</div>
                        <div class="msg_b">Yeah sure man.</div>
                        <div class="msg_insert"></div>
                    </div>
                    <div class="msg_footer"><textarea class="msg_input">Send Message</textarea></div> 
                </div>

                <div class="msg_box2">
                    <div class="msg_head2">Yusuf
                        <div class="close2">X</div>
                    </div>
                    <div class="msg_body2">
                        <div class="msg_a2">Wassup?</div>
                        <div class="msg_b2">Sup</div>
                        <div class="msg_insert2"></div>
                    </div>
                    <div class="msg_footer2"><textarea class="msg_input2">Send Message</textarea></div> 
                </div>
                
    </body>






</html>