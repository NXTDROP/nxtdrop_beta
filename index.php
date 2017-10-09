<?php 
    session_start();
    include "dbh.php";
?>
<!DOCTYPE html>
<html>
<title>
    NXTDROP: The Social
</title>
<head>
    <link type="text/css" rel="stylesheet" href="main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
</head>
<body>
    <header>
    <a><img id ="logo"src="img/nxtdroplogo.png" height="20px"></a>
    <a href="home.html"><i class="fa fa-home" aria-hidden="true"></i></a>
        
    <!--<a href="search.html"><i class="fa fa-search" aria-hidden="true"></i></a>-->
    <!--<div class="popup" onclick= "myFunction ()"><a href="search.html"><i class="fa fa-search" aria-hidden="true"></i></a>
        <span class="popuptext" id="mypopup"> Popup text </span>
    </div>-->
    <a href="likes.html"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
    <a href="profile.html"><i class="fa fa-user" aria-hidden="true"></i></a>
    <div class="search-bar">
        <form action="search.php" method="GET" id="search-bar">
        <input type="text" name="q" size="60" placeholder="Search" />
        </form>
    </div>
    </header>

    <section class="container">
        <div class="card">
            <div class="card-header">
                <div class="profile-img">
                </div>
                    
                <div class="profile-info">
                    <div class="name">Username</div>
                    <div class="location">Toronto, Ontario</div>

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

    </section>
 </body>
</html>