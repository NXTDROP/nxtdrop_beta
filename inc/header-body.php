<header>
    <a><img id ="logo"src="img/nxtdroplogo.png" height="20px"></a>
    <a href="index.php"><i class="fa fa-home" aria-hidden="true" title="Home"></i></a>
    <style>
    .fa-stack[data-count]:after{
        position:absolute;
        right:20%;
        top:25%;
        content: attr(data-count);
        font-size:30%;
        padding:.6em;
        border-radius:999px;
        line-height:.75em;
        color: white;
        background:rgba(255,0,0,.85);
        text-align:center;
        min-width:0.1em;
        font-weight:bold;
    }
    .fa-stack {
        bottom: 2.25px;
    }
    </style>
            
    <!--<a href="search.html"><i class="fa fa-search" aria-hidden="true"></i></a>-->
    <!--<div class="popup" onclick= "myFunction ()"><a href="search.html"><i class="fa fa-search" aria-hidden="true"></i></a>
        <span class="popuptext" id="mypopup"> Popup text </span>
    </div>-->
    <?php
        if(isset($_SESSION['uid'])) {
            $username = $_SESSION['username'];
            $result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) FROM messages WHERE u_to = '$username' AND opened = '0';"));
            if ($result['COUNT(*)'] > 0) {
                $message_icon = '<span class="fa-stack has-badge" data-count="">
                <i class="fa fa-envelope fa-stack-1x"></i>
            </span>';
            }
            else {
                $message_icon = '<span><i class="fa fa-envelope" aria-hidden="true" title="Direct Messages"></i></span>';
            }
            echo '<a href="likes.php"><i class="fa fa-heart-o" aria-hidden="true" title="Liked Drop"></i></a>
            <a href="profile.php?u='.$_SESSION['username'].'"><i class="fa fa-user" aria-hidden="true" title="Profile"></i></a>
            <a href="messages.php" class="dm_icon">'.$message_icon.'</a>';
        }
        else {
            echo '<a href="login.php"><i class="fa fa-heart-o" aria-hidden="true" title="Liked Drop"></i></a>
            <a href="login.php"><i class="fa fa-user" aria-hidden="true" title="Profile"></i></a>
            <a href="login.php"><i class="fa fa-envelope" aria-hidden="true" title="Direct Messages"></i></a>';
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
            <div class="dropdown"><i onclick="more()" class="fa fa-ellipsis-h" aria-hidden="true" id="dropbtn" title="Log Out"></i><div id="myDropdown" class="dropdown-content"><a href="login/logout.php">Log Out</a></div></div>';   
        }
        else {
            echo '<a href="login.php"><button class="login-button">Sign Up/Login</button></a>';
        }
    ?>
</header>