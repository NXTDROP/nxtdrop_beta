<script>
    $(document).ready(function() {
        $('#icon').click(function() {
            if ($('#search').css('display') == "none") {
                $('#icon').css('margin-left', '0%');
                $('#search').css('display', 'block');
                $('.search_post').fadeIn();
                $('.search_main').show();
            }
            else {
                $('#icon').css('margin-left', '44%');
                $('#search').css('display', 'none');
                $('.search_post').fadeOut();
                $('.search_main').fadeOut();
            }
        });

        $('.toggle_btn').click(function() {
            if ($('.menu-pop').css('display') == 'none') {
                $('.menu-main').css('left', '0%');
                $('.menu-pop').fadeIn();
            }
            else {
                $('.menu-main').css('left', '-16%');
                $('.menu-pop').fadeOut();
            }
        });

        $('.alert-btn').click(function() {
            if ($('.notif-main').css('display') == 'block') {
                $('.notif-main').fadeOut();
                $('.notif-pop').fadeOut();
            }
            else {
                $('.notif-main').fadeIn();
                $('.notif-pop').show();
            }
        });

        $('#notif').click(function() {
            if ($('.notif-main').css('display') == 'block') {
                $('.notif-main').fadeOut();
                $('.notif-pop').fadeOut();
            }
            else {
                $('.notif-main').fadeIn();
                $('.notif-pop').show();
            }
        });

        $('.drop-btn').click(function() {
            if ($('.post').css('display') == 'block') {
                $('.post').fadeOut();
                $('.post_main').fadeOut();
            }
            else {
                $('.post').fadeIn();
                $('.post_main').show();
            }
        });

        $(".close").click(function(){
            $(".post").fadeOut();
            $(".post_main").fadeOut();
        });

        $('.close').click(function() {
            $('.menu-main').css('left', '-16%');
            $('.menu-pop').fadeOut();
            $('.notif-main').fadeOut();
            $('.notif-pop').fadeOut();
        });

        $(document).scroll(function() {
            if ($(document).scrollTop() >= 60) {
                $('.navbar').css('background', '#fff');
                $('.navbar').css('border-bottom', '1px solid #e6e1e1');
            }
            else {
                $('.navbar').css('background', 'transparent');
                $('.navbar').css('border-bottom', 'none');
            }
        });
    });
</script>

<nav class="navbar navbar-expand-xl sticky-top">
    <button class="toggle_btn">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <a href="https://nxtdrop.com" id="navbar-brand"><img src="https://nxtdrop.com/img/nxtdroplogo.png"></a>

    <div class="search-box">
        <input type="search" id="search" placeholder="Search..."/>
        <span class="fa fa-search" id="icon"></span>
    </div>

    <?php
        if (isset($_SESSION['uid'])) {
            $uid = $_SESSION['uid'];
            $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM profile, users WHERE users.uid = '$uid' AND profile.uid = '$uid'"));
            $pic = $row['status'];
            $username = $row['username'];
            echo '<button class="drop-btn" title="List/Request An Item"><i class="fa fa-plus" aria-hidden="true"></i></button>

            <button class="alert-btn" title="Notifications"><i class="fa fa-bell" aria-hidden="true"></i></button>
            
            <a href="https://nxtdrop.com/u/'.$username.'"><img id="nav-profile" src="https://nxtdrop.com/'.$pic.'"/></a>';
        }
        else {
            echo '<button class="drop-btn" title="List/Request An Item" style="display: none"><i class="fa fa-plus" aria-hidden="true"></i></button>

            <button class="alert-btn" title="Notifications" style="display: none"><i class="fa fa-bell" aria-hidden="true"></i></button>
            
            <a id="login-btn" href="login.php"><button class="sign-btn" title="Login/Sign Up">SIGN IN</button></a>';
        }
    ?>
</nav>

<div class="menu-pop">
    <div class="menu-close close"></div>
    <div class="menu-main">
        <div class="menu-content">
            <ul>
                <a href="https://nxtdrop.com"><li><span><i class="fa fa-home" aria-hidden="true"></i></span>HOME</li></a>
                <?php
                    if (isset($_SESSION['uid'])) {
                        echo '<a href="messages.php"><li><span><i class="fa fa-envelope" aria-hidden="true"></i></span>INBOX</li></a>
                        <a id="notif"><li><span><i class="fa fa-bell" aria-hidden="true"></i></span>NOTIFICATIONS</li></a>
                        <a href="https://nxtdrop.com/u/'.$username.'"><li><span><i class="fa fa-user" aria-hidden="true"></i></span>MY PROFILE</li></a>
                        <a href="login/logout.php"><li><span><i class="fa fa-sign-out" aria-hidden="true"></i></span>LOGOUT</li></a>';
                    }
                ?>
            </ul>
            <?php
                if (!isset($_SESSION['uid'])) {
                    echo '<hr/>
                    <p id="signin-message">Sign in now to buy, sell, trade and discover fashion!</p>
                    <a href="#" id="signin-slide-btn">SIGN IN</a>';
                }
            ?>
            <hr/>
            <div class="menu-footer">
                <p>&copy NXTDROP Inc. 2018</p>
                <a href="terms">TERMS OF USE</a>
                <a href="privacy">PRIVACY</a>
            </div>
        </div>
    </div>
</div>

<div class="notif-pop">
    <div class="notif-close close"></div>
    <div class="notif-main">
        <div class="notif-header">
            <h2>Notifications</h2>
        </div>
        <div class="notif-content">
            <p>You have 0 notifications.</p>
        </div>
    </div>
</div>