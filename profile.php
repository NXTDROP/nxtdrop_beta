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
      <section class="container">
        <div class="profile-info">
          <div class="name">Youssoupha</div>
          <div class="at">@yusuf</div>
        </div>
        <button class="edit-button">Edit Profile</button>
      </section>
     
      <hr>



    </body>

</html>