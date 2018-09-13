<script>
    var new_notifications = false;
    var check_rerun;
    var inbox;

    function go_to_post(id) {
        window.location.replace('p/'+id);
    }

    function go_to_profile(username) {
        window.location.replace('u/'+username);
    }

    function go_to_inbox() {
        window.location.replace('inbox');
    }

    function load_notifications() {
        $('.notif_results').html('<p><i class="fas fa-circle-notch fa-spin"></i></p>');
        $.ajax({
            url: 'inc/navbar/load_notifications.php',
            type: 'GET',
            success: function(data) {
                $('.notif_results').html(data);
            }
        });
    }

    function check_notifications() {
        $.ajax({
            url: 'inc/navbar/check_notifications.php',
            type: 'GET',
            success: function(response) {
                if (response == true) {
                    $('.alert-btn').html('<span class="fa-layers fa-fw"><i class="fas fa-bell"></i><span class="fa-layers-counter" style="background:Tomato"></span></span>');
                    $('#notif').html('<li><span class="fa-layers fa-fw"><i class="fas fa-bell"></i><span class="fa-layers-counter" style="background:Tomato"></span></span>NOTIFICATIONS</li>');
                    load_notifications();
                    new_notifications = true;
                }
            },
            complete: function() {
                check_rerun = setTimeout(function() {
                    check_notifications();
                }, 10000);
            }
        });
    }

    function viewed_notifications() {
        $.ajax({
            url: 'inc/navbar/viewed_notifications.php',
            type: 'GET'
        });
    }

    function check_inbox() {
        $.ajax({
            url: 'inc/navbar/check_inbox.php',
            type: 'GET',
            success: function(response) {
                if (response == true) {
                    $('#inbox').html('<li><span class="fa-layers fa-fw"><i class="fas fa-envelope"></i><span class="fa-layers-counter" style="background:Tomato"></span></span>INBOX</li>');
                    $('.toggle_btn').css('background', 'Tomato');
                }
            },
            complete: function() {
                inbox = setTimeout(function() {
                    check_inbox();
                }, 2500);
            }
        });
    }

    function order_MMShipping(ID, tID, bID) {
        window.location.replace('orderPlaced.php?item=' + ID + '&bID=' + bID + '&tID=' + tID + '&tracking=true');
    }

    check_notifications();
    load_notifications();
    check_inbox();

    $(document).ready(function() {
        $('#icon').click(function() {
            if ($('#search').css('display') == "none") {
                $('#icon').css('margin-left', '0%');
                $('#search').css('display', 'block');
                $('.search_post').fadeIn();
                $('.search_main').show();
                $('#icon').html('<i class="fas fa-search-minus"></i>');
            }
            else {
                $('#icon').css('margin-left', '44%');
                $('#search').css('display', 'none');
                $('.search_post').fadeOut();
                $('.search_main').fadeOut();
                $('#icon').html('<i class="fas fa-search-plus"></i>');
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
                if (new_notifications == true) {
                    $('.alert-btn').html('<i class="fas fa-bell"></i>');
                    $('#notif').html('<li><span><i class="fas fa-bell"></i></span>NOTIFICATIONS</li>');
                    viewed_notifications();
                }
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
                if (new_notifications == true) {
                    $('.alert-btn').html('<i class="fas fa-bell"></i>');
                    $('#notif').html('<li><span><i class="fas fa-bell"></i></span>NOTIFICATIONS</li>');
                    viewed_notifications();
                }
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
        <span id="icon"><i class="fas fa-search-plus"></i></span>
    </div>

    <?php
        if (isset($_SESSION['uid'])) {
            $uid = $_SESSION['uid'];
            $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM profile, users WHERE users.uid = '$uid' AND profile.uid = '$uid'"));
            if ($row['status'] != '') {
                $pic = $row['status'];
            }
            else {
                $pic = 'uploads/user.png';
            }
            $username = $row['username'];
            echo '<button class="drop-btn" title="List/Request An Item"><i class="fa fa-plus" aria-hidden="true"></i></button>

            <button class="alert-btn" title="Notifications"><i class="fas fa-bell"></i></button>
            
            <a href="u/'.$username.'"><img id="nav-profile" src="'.$pic.'"/></a>';
        }
        else {
            echo '<button class="drop-btn" title="List/Request An Item" style="display: none"><i class="fa fa-plus" aria-hidden="true"></i></button>

            <button class="alert-btn" title="Notifications" style="display: none"><i class="fa fa-bell"></i></button>
            
            <a id="login-btn" href="login_signup"><button class="sign-btn" title="Login/Sign Up">SIGN IN</button></a>';
        }
    ?>
</nav>

<div class="menu-pop">
    <div class="menu-close close"></div>
    <div class="menu-main">
        <div class="menu-content">
            <ul>
                <a href="https://nxtdrop.com"><li><span><i class="fas fa-home"></i></span>HOME</li></a>
                <?php
                    if (isset($_SESSION['uid'])) {
                        echo '
                        <a href="dashboard"><li><span><i class="fas fa-clipboard" style="color: #888888;"></i></span>DASHBOARD</li></a>
                        <a href="inbox" id="inbox"><li><span><i class="fas fa-envelope"></i></span>INBOX</li></a>
                        <a id="notif"><li><span><i class="fas fa-bell"></i></span>NOTIFICATIONS</li></a>
                        <a href="u/'.$username.'"><li><span><i class="fa fa-user" aria-hidden="true"></i></span>PROFILE</li></a>
                        <a href="settings"><li><span><i class="fas fa-cog" style="color: #888888;"></i></span>SETTINGS</li></a>
                        <a href="logout"><li><span><i class="fas fa-sign-out-alt" aria-hidden="true"></i></span>LOGOUT</li></a>';
                    }
                ?>
            </ul>
            <?php
                if (!isset($_SESSION['uid'])) {
                    echo '<hr/>
                    <p id="signin-message">Sign in now to buy, sell, trade and discover fashion!</p>
                    <a href="login_signup" id="signin-slide-btn">SIGN IN</a>';
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
            <div class="notif_results">
            </div>
            
        </div>
    </div>
</div>