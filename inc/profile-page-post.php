<div id="posts-container">
            <?php
                $sql = "SELECT * FROM users WHERE username = '".$_GET['u']."';";
                $result = mysqli_query($conn, $sql);
                $r = mysqli_fetch_assoc($result);
                $u_id = $r['uid'];
                $sql = "SELECT * FROM posts, users WHERE posts.uid = ".$u_id." AND users.username = '".$_GET['u']."' ORDER BY posts.pdate DESC LIMIT 5;";
                $result = mysqli_query($conn, $sql);
                if (!mysqli_num_rows($result) > 0) {
                    echo '<p id="no_post">No Posts Available!</p>';
                }
                else {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<section class="container post-'.$row['pid'].'">
                        <div class="card">
                            <div class="card-header">
                                <div class="post-profile-img"><img class="post-small-img" src="'.$status.'">
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
                                <hr />';
                                if (isset($_SESSION['uid']) && $_SESSION['uid'] == $row['uid']) {
                                    echo '
                                    <div class="post_form_bottom">
                                        <input type="hidden" name="pid" value="'.$row['pid'].' id="pid">
                                        <div class="heart">
                                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                                        </div>
                                        <div onclick="delete_('.$row['pid'].')" class="remove">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </div>
                                        <div class="flag">
                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                        </div>
                
                                        <!--<div class="add-comment">
                                            <input type="text" placeholder="Drop a comment..." />
                                        </div>-->
                                    </div>
                                </div>
                
                            </div>    
                            </section>';
                                }
                                else {
                                    echo '
                                    <div class="post_form_bottom">
                                        <input type="hidden" name="pid" value="'.$row['pid'].'">
                                        <div class="heart">
                                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                                        </div>
                                        <div class="flag">
                                            <i class="fa fa-flag" aria-hidden="true"></i>
                                        </div>
                
                                        <!--<div class="add-comment">
                                            <input type="text" placeholder="Drop a comment..." />
                                        </div>-->
                                    </div>
                                </div>
                
                            </div>    
                            </section>';
                                }
                    }
                }
            ?>
        </div>