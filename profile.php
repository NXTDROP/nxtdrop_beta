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
        <a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
        <a href="profile.php"><i class="fa fa-user" aria-hidden="true"></i></a>
        <div class="search-bar">
            <form action="search.php" method="GET" id="search-bar">
            <input type="text" name="q" size="60" placeholder="Search" />
            </form>
        </div>
        <div class="dropdown">
            <i onclick="more()" class="fa fa-ellipsis-h" aria-hidden="true" id="dropbtn"></i>
            <div id="myDropdown" class="dropdown-content">
                <a href="#">Settings</a>
                <a href="login/logout.php">Log Out</a>
            </div>
        </div>
      </header>
      <section class="container-top">
        <div class="profile-info">
          <div class="name">Youssoupha</div>
          <div class="at">@yusuf</div>
        </div>
        <button class="edit-button">Edit Profile</button>
      </section>
    <hr>

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
        <p>&copy NXTDROP Inc. 2017</p>
        <ul>
            <li><a href="#">About</a></li>
            <li><a href="#">Terms &amp Privacy</a></li>
        </ul>
    </section>

    </body>

</html>