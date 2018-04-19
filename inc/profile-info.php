<div class="container-top">
    <script type="text/javascript">
        function follow() {
            $('.follow_unfollow').html('+ Follow');
        }

        function unfollow() {
            $('.follow_unfollow').html('- Unfollow');            
        }

        $(document).ready(function() {
            $('.follow_unfollow').click(function() {
                $('follow_unfollow').attr('disabled', true);
                var val = $(this).html();
                if (val == '+ Follow') {
                    var follower_username = <?php echo "'".$_GET['u']."'"?>;
                    var type = 'follow';
                    $.ajax({
                        type: 'POST',
                        url: 'inc/following_sys/follow_unfollow.php',
                        data: {follower_username:follower_username, type:type},
                        success: function (data) {
                            if (data == '') {
                                $('.follow_unfollow').html('- Unfollow');
                                $('.follow_unfollow').delay(2500).attr('id', 'unfollow');
                                $('follow_unfollow').attr('disabled', false);
                            }
                            else {
                                $('.follow_unfollow').html(data);
                                timeoutID = window.setTimeout(follow, 2500);
                                $('follow_unfollow').attr('disabled', false);
                            }
                        }
                    });
                }
                else {
                    var follower_username = <?php echo "'".$_GET['u']."'"?>;
                    var type = 'unfollow';
                    $.ajax({
                        type: 'POST',
                        url: 'inc/following_sys/follow_unfollow.php',
                        data: {follower_username:follower_username, type:type},
                        success: function (data) {
                            if (data == '') {
                                $('.follow_unfollow').html('+ Follow');
                                $('.follow_unfollow').delay(2500).attr('id', 'follow');
                                $('follow_unfollow').attr('disabled', false);
                            }
                            else {
                                $('.follow_unfollow').html(data);
                                timeoutID = window.setTimeout(unfollow, 2500);
                                $('follow_unfollow').attr('disabled', false);
                            }
                        }
                    });
                }
            });
        });
    </script>
<?php

    $sql = "SELECT uid FROM users WHERE username = '".$_GET['u']."';";
    $result = mysqli_query($conn, $sql);
    $r = mysqli_fetch_assoc($result);
    $u_id = $r['uid'];
    $user_id = $_SESSION['uid'];

    $sql = "SELECT status FROM profile WHERE uid=$u_id;";
    $result = mysqli_query($conn, $sql);
    $r = mysqli_fetch_assoc($result);
    $status = $r['status'];
    if ($status == "") $status = 'uploads/user.png';
    
    echo '<div class="profile-img-profile"><img id="myprofile" style="height: 100%; width: 100%; object-fit: cover; z-index: 0;" src="'.$status.'"></div>';

    $sql = "SELECT * FROM profile, users WHERE profile.uid=$u_id AND users.username='".$_GET['u']."';";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        echo '<h2>'.$row['name'].'</h2></br>
        <h3>@'.$row['username'].'</h3>
        <p>'.$row['bio'].'</p>'; 
        $sql = "SELECT * FROM following WHERE user_id='$user_id' AND follower_id='$u_id'";
        $result = $conn->query($sql);
        if ($result->num_rows < 1) {
            echo '<button class="follow_unfollow" id="follow">+ Follow</button>';
        }
        else {
            echo '<button class="follow_unfollow" id="unfollow">- Unfollow</button>';
        }
    }
    else {
        echo '<h2></h2>
        <h3></h3>
        <p></p>';
    }

    if(isset($_SESSION['uid']) && $_GET['u'] == $_SESSION['username']) {
        echo '<a href="edit_profile"><button class="edit-button">Edit Profile</button></a>';
    }

?>
</div>