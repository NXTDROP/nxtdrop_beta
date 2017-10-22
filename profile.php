<!DOCTYPE html>

<html>
    <title>
        NXTDROP: The Social Marketplace
    </title>
    <head>
        <link type="text/css" rel="stylesheet" href="profile.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        <script type="text/javascript" src="js/menu-dropdown.js"></script>        
    </head>

    <body>
        <header>
            <a><img id ="logo"src="img/nxtdroplogo.png" height="20px"></a>
            <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i></a>
                
            <!--<a href="search.html"><i class="fa fa-search" aria-hidden="true"></i></a>-->
            <!--<div class="popup" onclick= "myFunction ()"><a href="search.html"><i class="fa fa-search" aria-hidden="true"></i></a>
                <span class="popuptext" id="mypopup"> Popup text </span>
            </div>-->
            <a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
            <a href="profile.php"><i class="fa fa-user" aria-hidden="true"></i></a>
            <div class="search-bar">
                <form action="search.php" method="GET" id="search-bar">
                <input type="text" name="q" size="60" placeholder="Search" />
                </form>
            </div>
            <?php
                if(isset($_SESSION['uid'])) {
                    echo '<div class="dropdown">
                    <i onclick="more()" class="fa fa-ellipsis-h" aria-hidden="true" id="dropbtn"></i>
                    <div id="myDropdown" class="dropdown-content">
                        <a href="#">Settings</a>
                        <a href="login/logout.php">Log Out</a>
                    </div>
                </div>';
                }
                else {
                    echo '<a href="login.php"><button class="login-button">Sign Up/Login</button></a>';
                }
            ?>
        </header>
        
        <div class="container-top">
            <div class="profile-img"><img style='height: 100%; width: 100%; object-fit: cover' src="uploads/yeezy.jpg"></div>
            <h2>Momar Cisse</h2>
            <h3>@momarcissex</h3>
            <p>God'Speed™ 👕 • they never loved us.</p>
            <button class="edit-button">Edit Profile</button>
        </div>

        <section class="container">
            <div class="card">
                <div class="card-header">
                    <div class="post-profile-img">
                    </div>
                        
                    <div class="profile-info">
                        <div class="name">Username</div>
                <!--    <div class="location">Toronto, Ontario</div> change location to @username -->

                    </div>

                    <!--<div class="profile-img">
                    </div> -->

                    <div class="time">
                                1hr
                    </div>
                </div>
                <div class="content">
                    <img src="uploads/yeezy.jpg">
                </div>

                <div class="card-footer">
                    <div class="likes">
                        1,000 likes
                    </div>

                    <div class="description">
                        <p>
                            <span class="username">Username</span> My new Yeezy's.
                        </p>
                    </div>
                    <!--<div class="comments">
                        <p>
                            <span class="username">Youssoupha24</span> Nice shoes.
                        </p>
                        <p>
                            <span class="username">Blvckpvblo</span> Wanna trade with my Jordan IV?.
                        </p>
                    </div>-->
                    <hr />
                    <form class="form">
                        <div class="heart">
                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                        </div>
                        <div class="options">
                            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                        </div>

                        <!--<div class="add-comment">
                            <input type="text" placeholder="Drop a comment..." />
                        </div>-->
                    </form>
                </div>

            </div>    
        </section>

        <section class="footer">
            <p>&copy NXTDROP Inc. 2017</p>
            <ul>
                <li><a href="#">About</a></li>
                <li><a href="#">Terms &amp Privacy</a></li>
            </ul>
        </section>

    </body>

</html>