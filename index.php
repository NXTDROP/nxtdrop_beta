<?php 
    session_start();
    include "dbh.php";
?>
<!DOCTYPE html>
<html>
    <title>
        NXTDROP: The Social Marketplace
    </title>
    <head>
        <link type="text/css" rel="stylesheet" href="main.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/menu-dropdown.js"></script>
        <script>
            $(document).ready(function(){
                $(".call_post").click(function(){
                    $(".post").fadeIn();
                    $(".post_main").show();
                });
            });
            $(document).ready(function(){
                $(".close").click(function(){
                    $(".post").fadeOut();
                    $(".post_main").fadeOut();
                });
            });
        </script>
    </head>
    <body>
        <header>
        <a><img id ="logo"src="img/nxtdroplogo.png" height="20px"></a>
        <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i></a>
            
        <!--<a href="search.html"><i class="fa fa-search" aria-hidden="true"></i></a>-->
        <!--<div class="popup" onclick= "myFunction ()"><a href="search.html"><i class="fa fa-search" aria-hidden="true"></i></a>
            <span class="popuptext" id="mypopup"> Popup text </span>
        </div>-->
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

        <section class="container">
            <div class="card">
                <div class="card-header">
                    <div class="profile-img">
                    </div>
                        
                    <div class="profile-info">
                        <div class="name"><p>Username</p></div>
                        <!--<div class="location">Toronto, Ontario</div>-->

                    </div>

                    <!--<div class="profile-img">
                    </div> -->

                    <div class="time">
                        <p>1hr</p>
                    </div>
                </div>
                <div class="content">
                    <img src="uploads/yeezy.jpg">
                </div>

                <div class="card-footer">
                    <div class="likes"><p>1,000 likes</p></div>

                    <div class="description">
                        <p><span class="username">Username</span> My new Yeezy's.</p>
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

        <script>
            var inputs = document.querySelectorAll( '.inputfile' );
Array.prototype.forEach.call( inputs, function( input )
{
	var label	 = input.nextElementSibling,
		labelVal = label.innerHTML;

	input.addEventListener( 'change', function( e )
	{
		var fileName = '';
		if( this.files && this.files.length > 1 )
			fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
		else
			fileName = e.target.value.split( '\\' ).pop();

		if( fileName )
			label.querySelector( 'span' ).innerHTML = fileName;
		else
			label.innerHTML = labelVal;
	});
});
        </script>

        <div class="post">
            <div class="post_close close"></div>
            <div class="post_main">
                <h2>Post new Drop</h2>
                <div class="post_content">
                    <form action="" method="POST" id="post" class="post-form">
                        <textarea name="caption" placeholder="Enter Description" id="caption"></textarea>
                        <input type="file" name="file" id="file" class="inputfile" data-multiple-caption="{count} files selected" multiple />
                        <label for="file"><i class="fa fa-picture-o" aria-hidden="true"></i></label>
                        <button type="submit" name="submit" id="submit">Drop</button>
                    </form>
                </div>
            </div>
        </div>

        <section class="footer">
            <p>&copy NXTDROP Inc. 2017</p>
            <ul>
                <li><a href="#">About</a></li>
                <li><a href="#">Terms &amp Privacy</a></li>
            </ul>
        </section>
    </body>
</html>