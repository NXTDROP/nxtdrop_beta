<?php
        session_start();
        include '../dbh.php';
        include 'time.php';
        include 'num_conversion.php';
        $count = $_POST['count'];
        $timestamp = $_SESSION['timestamp'];
        $sql = "SELECT * FROM posts, users, profile WHERE posts.uid = users.uid AND users.uid = profile.uid AND posts.pdate <= '$timestamp' ORDER BY posts.pdate DESC LIMIT $count;";
        $result = mysqli_query($conn, $sql);

        if (!mysqli_num_rows($result) > 0) {
            echo '<p id="no_post">No Posts Available!</p>';
        }
        else {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['status'] == "") $row['status'] = "uploads/user.png";

                $like_class = 'fa fa-heart-o';
                if (isset($_SESSION['uid'])) {
                    $query = "SELECT pid FROM likes WHERE liked_by = ".$_SESSION['uid']." AND pid = ".$row['pid'].";";
                    $q_result = mysqli_query($conn, $query);
                    $q_row = mysqli_fetch_assoc($q_result);
                    if ($row['pid'] == $q_row['pid']) $like_class = 'fa fa-heart';
                }
                
                if ($row['pic'] == '') {
                    echo '<section class="container post-'.$row['pid'].'">
                <div class="card">
                <div class="card-header">
                <div class="profile-img-index"><img class="post-small-img" src="'.$row['status'].'">
                </div>
                                    
                <div class="profile-info">
                <div class="name"><p><a href="u/'.$row['username'].'">'.$row['username'].'</a></p></div>
                <!--<div class="location">Toronto, Ontario</div>-->
            
                </div>
            
                <div class="time">
                <p>'.getPostTime($row['pdate']).'</p>
                </div>
                </div>
            
                <div class="card-footer">
            
                <div class="description">
                <p><span class="caption"> '.$row['caption'].'</span></p>
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
                if (isset($_SESSION['uid'])) {
                    if ($_SESSION['uid'] == $row['uid']) {
                        echo '
                    <div class="post_form_bottom">
                    <input type="hidden" name="pid" value="'.$row['pid'].' id="pid">
                    <div class="heart">';
                    echo '<span class="fa-stack has-badge" id="likes-'.$row['pid'].'" count="'.likes($row['likes']).'"><i class="'.$like_class.'" aria-hidden="true" id="heart-'.$row['pid'].'" onclick="like(this.id, '.$row['pid'].', '.$row['uid'].', '.$row['likes'].')" title="Likes"></i></span>';
                    echo '</div>
                    <div onclick="delete_('.$row['pid'].')" class="remove">
                    <i class="fa fa-times" aria-hidden="true" title="Delete Drop"></i>
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
                        $u = "'".$row['username']."'";
                        echo '
                    <div class="post_form_bottom">
                    <input type="hidden" name="pid" value="'.$row['pid'].'">
                    <div class="heart_noremove">';
                    echo '<span class="fa-stack has-badge" id="likes-'.$row['pid'].'" count="'.likes($row['likes']).'"><i class="'.$like_class.'" aria-hidden="true" id="heart-'.$row['pid'].'" onclick="like(this.id, '.$row['pid'].', '.$row['uid'].', '.$row['likes'].')" title="Likes"></i></span>';
                    echo '</div>
                    <div class="direct_message">
                    <i class="fa fa-envelope-o" aria-hidden="true" onclick="send('.$u.')" title="Send DM"></i>
                    </div>
                    <div class="flag">
                    <i class="fa fa-flag" aria-hidden="true" onclick="flag('.$row['pid'].')" title="Report Drop"></i>
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
                else {
                    echo '
                    <div class="post_form_bottom">
                    <input type="hidden" name="pid" value="'.$row['pid'].'">
                    <div class="heart_noremove">';
                    echo '<span class="fa-stack has-badge" count="'.$row['likes'].'"><i class="'.$like_class.'" aria-hidden="true" id="heart-'.$row['pid'].'" title="Likes"></i></span>';
                    echo '</div>
                    <div class="flag">
                    <i class="fa fa-flag" aria-hidden="true" title="Report Drop"></i>
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
                else {
                    echo '<section class="container post-'.$row['pid'].'">
                <div class="card">
                <div class="card-header">
                <div class="profile-img-index"><img class="post-small-img" src="'.$row['status'].'">
                </div>
                                    
                <div class="profile-info">
                <div class="name"><p><a href="u/'.$row['username'].'">'.$row['username'].'</a></p></div>
                <!--<div class="location">Toronto, Ontario</div>-->
            
                </div>
            
                <div class="time">
                <p>'.getPostTime($row['pdate']).'</p>
                </div>
                </div>
                <div class="content">
                <img src="'.$row['pic'].'">
                </div>
            
                <div class="card-footer">
            
                <div class="description">
                <p><span class="username"><a href="u/'.$row['username'].'">'.$row['username'].'</a></span><span class="caption"> '.$row['caption'].'</span></p>
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
                if (isset($_SESSION['uid'])) {
                    if ($_SESSION['uid'] == $row['uid']) {
                        echo '
                    <div class="post_form_bottom">
                    <input type="hidden" name="pid" value="'.$row['pid'].' id="pid">
                    <div class="heart">';
                    echo '<span class="fa-stack has-badge" id="likes-'.$row['pid'].'" count="'.likes($row['likes']).'"><i class="'.$like_class.'" aria-hidden="true" id="heart-'.$row['pid'].'" onclick="like(this.id, '.$row['pid'].', '.$row['uid'].', '.$row['likes'].')" title="Likes"></i></span>';
                    echo '</div>
                    <div onclick="delete_('.$row['pid'].')" class="remove">
                    <i class="fa fa-times" aria-hidden="true" title="Delete Drop"></i>
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
                        $u = "'".$row['username']."'";
                        echo '
                    <div class="post_form_bottom">
                    <input type="hidden" name="pid" value="'.$row['pid'].'">
                    <div class="heart_noremove">';
                    echo '<span class="fa-stack has-badge" id="likes-'.$row['pid'].'" count="'.likes($row['likes']).'"><i class="'.$like_class.'" aria-hidden="true" id="heart-'.$row['pid'].'" onclick="like(this.id, '.$row['pid'].', '.$row['uid'].', '.$row['likes'].')" title="Likes"></i></span>';
                    echo '</div>
                    <div class="direct_message">
                    <i class="fa fa-envelope-o" aria-hidden="true" onclick="send('.$u.')" title="Send DM"></i>
                    </div>
                    <div class="flag">
                    <i class="fa fa-flag" aria-hidden="true" onclick="flag('.$row['pid'].')" title="Report Drop"></i>
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
                else {
                    echo '
                    <div class="post_form_bottom">
                    <input type="hidden" name="pid" value="'.$row['pid'].'">
                    <div class="heart_noremove">';
                    echo '<span class="fa-stack has-badge" count="'.$row['likes'].'"><i class="'.$like_class.'" aria-hidden="true" id="heart-'.$row['pid'].'" title="Likes"></i></span>';
                    echo '</div>
                    <div class="flag">
                    <i class="fa fa-flag" aria-hidden="true" title="Report Drop"></i>
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
        }
        /*if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM posts;")) >= 15) {
            echo '<button class="load_drop">More Drops</button>';
        }
        else {
            echo '';
        }*/
?>