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
        <script type="text/javascript" src="js/post-popup.js"></script>
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
                <a href="profile.php?u='.$_SESSION['username'].'"><i class="fa fa-user" aria-hidden="true"></i></a>';
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

        <div id="posts-container">
            <?php
                $sql = "SELECT * FROM posts, users WHERE posts.uid = users.uid ORDER BY posts.pdate DESC LIMIT 2;";
                $result = mysqli_query($conn, $sql);
                if (!mysqli_num_rows($result) > 0) {
                    echo '<p id="no_post">No Posts Available!</p>';
                }
                else {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<section class="container">
                        <div class="card">
                            <div class="card-header">
                                <div class="profile-img">
                                </div>
                                    
                                <div class="profile-info">
                                    <div class="name"><p><a href="profile.php?u='.$row['username'].'">'.$row['username'].'</a></p></div>
                                    <!--<div class="location">Toronto, Ontario</div>-->
            
                                </div>
            
                                <!--<div class="profile-img">
                                </div> -->
            
                                <div class="time">
                                    <p>'.$row['pdate'].'</p>
                                </div>
                            </div>
                            <div class="content">
                                <img src="'.$row['pic'].'">
                            </div>
            
                            <div class="card-footer">
                                <div class="likes"><p>'.$row['likes'].' likes</p></div>
            
                                <div class="description">
                                    <p><span class="username"><a href="profile.php?u='.$row['username'].'">'.$row['username'].'</a></span> '.$row['caption'].'</p>
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
                    </section>';
                    }
                }
            ?>
        </div>

        <div class="post">
            <div class="post_close close"></div>
            <div class="post_main">
                <h2>New Drop</h2>
                <div class="post_content">
                    <form action="post/post.php" method="POST" enctype="multipart/form-data" id="post" class="post-form">
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