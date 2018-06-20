<script type="text/javascript">
    function follow(username) {
        $('#follow_'+username).css('display', 'none');
        $.ajax({
            type: 'POST',
            url: 'inc/following_sys/follow_unfollow.php',
            data: {follower_username:username, type:'follow'},
            success: function(data) {
                if (data != '') {
                    $('#follow_'+username).attr('disabled', false);
                    $('#follow_'+username).css('display', 'block');
                    alert(data);
                }
            }
        });
    }
</script>

<?php
        session_start();
        include '../dbh.php';
        include 'time.php';
        include 'num_conversion.php';
        include 'following_sys/functions.php';
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

                $like_class = 'far fa-heart like';
                if (isset($_SESSION['uid'])) {
                    $query = "SELECT pid FROM likes WHERE liked_by = ".$_SESSION['uid']." AND pid = ".$row['pid'].";";
                    $q_result = mysqli_query($conn, $query);
                    $q_row = mysqli_fetch_assoc($q_result);
                    if ($row['pid'] == $q_row['pid']) $like_class = 'fas fa-heart unlike';
                }

                $username = "'".$row['username']."'";
                
                echo '<section class="container post-'.$row['pid'].'">
                <div class="card">
                <div class="card-header">
                                    
                <div class="profile-info">
                <div class="profile-img-index"><img class="post-small-img" src="'.$row['status'].'"></div>
                <div class="name"><span><a href="u/'.$row['username'].'">'.$row['username'].'</a></span>';
                if (isset($_SESSION['uid'])) {
                    if (isFriend($row['username']) == true && $_SESSION['uid'] != $row['uid']) {
                        echo '<div class="follow"><button class="follow_button" id="follow_'.$row['username'].'" onclick="follow('.$username.')" title="Follow '.$row['username'].'">+ Follow</button></div>';
                    }
                }
                else {
                    echo '<div class="follow"><button class="follow_disabled" title="Follow">+ Follow</button></div>';
                }
                echo '</div>';

                echo '<!--<div class="location">Toronto, Ontario</div>-->';
                
                if ($row['type'] == 'sale') {
                    echo '<p class="drop_type" id="sale_banner">SALE</p>';
                }
                else if ($row['type'] == 'request') {
                    echo '<p class="drop_type" id="request_banner">REQUEST</p>';
                }
                else if ($row['type'] == 'trade') {
                    echo '<p class="drop_type" id="trade_banner">TRADE</p>';
                }
            
                echo '</div>
            
                <div class="time">
                <p>'.getPostTime($row['pdate']).'</p>
                </div>
                </div>';

                if ($row['pic'] != '') {
                    echo '<div class="content">
                    <img src="'.$row['pic'].'">
                    </div>';
                }
            
                echo '<div class="card-footer">
            
                <div class="description">
                <p><span class="caption"><span class="name_caption"><a href="u/'.$row['username'].'">'.$row['username'].'</a></span> '.$row['caption'].'</span></p>';
                if ($row['type'] == 'sale') {
                    echo '<p id="price_budget">Price: <span id="cash">$'.$row['product_price'].'</span></p>';
                }
                else if ($row['type'] == 'request') {
                    echo '<p id="price_budget">Budget: <span id="cash">$'.$row['product_price'].'</span></p>';
                }
                else if ($row['type'] == 'trade') {
                    echo '<p id="trading_for">Trading for: <span id="trade_items">'.$row['product_price'].'</span></p>';
                }
                echo '</div>
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
                        echo '<span class="fa-layers fa-fw" id="likes-'.$row['pid'].'"><i class="'.$like_class.'" id="heart-'.$row['pid'].'" onclick="like(this.id, '.$row['pid'].', '.$row['uid'].')" title="Likes"></i><span class="fa-layers-counter" id="count-'.$row['pid'].'" style="background:Tomato">'.likes($row['likes']).'</span></span>';
                        echo '</div>';
                    
                        if ($row['uid'] != 'request') {
                            $type = 0;
                            echo '<div class="sold_button">
                        <button id="sold_button" onclick="sold('.$pid.', '.$type.')" title="Sold Already? Click Here! ">SOLD OUT?</button>
                        </div>';
                        }
                        else {
                            $type = 1;
                            echo '<div class="sold_button">
                        <button id="sold_button" onclick="sold('.$pid.', '.$type.')" title="Found Already? Click Here! ">FOUND?</button>
                        </div>';
                        }

                        echo '<div onclick="delete_('.$row['pid'].')" class="remove">
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
                        $pid = $row['pid'];
                        echo '
                        <div class="post_form_bottom">
                        <input type="hidden" name="pid" value="'.$row['pid'].'">
                        <div class="heart_noremove">';
                        echo '<span class="fa-layers fa-fw" id="likes-'.$row['pid'].'"><i class="'.$like_class.'" id="heart-'.$row['pid'].'" onclick="like(this.id, '.$row['pid'].', '.$row['uid'].')" title="Likes"></i><span class="fa-layers-counter" id="count-'.$row['pid'].'" style="background:Tomato">'.likes($row['likes']).'</span></span>';
                        echo '</div>
                        <div class="direct_message">
                        <button onclick="send('.$u.', '.$pid.')" title="Send Offer">SEND OFFER</button>
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
                    echo '<span class="fa-layers fa-fw" id="likes-'.$row['pid'].'"><i class="'.$like_class.'" id="heart-'.$row['pid'].'" title="Likes"></i><span class="fa-layers-counter" style="background:Tomato">'.likes($row['likes']).'</span></span>';
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
?>