<div class="container-top">
    <script type="text/javascript">
        function follow() {
            $('.follow_unfollow').html('+ Follow');
        }

        function unfollow() {
            $('.follow_unfollow').html('- Unfollow');     
        }

        function star_display(rating) {
            if (rating >= 0.0 && rating <= 2.99) {
                $('#star-rating').css('color', '#aa0000');
            }
            else if (rating >= 3.00 && rating <= 3.99) {
                $('#star-rating').css('color', '#bb743c');
            }
            else if (rating >= 4.00 && rating <= 4.49) {
                $('#star-rating').css('color', '#a3a3a3');
            }
            else if (rating >= 4.50 && rating <= 5.00) {
                $('#star-rating').attr('style', 'color: #D4AF37');
            }
            else {
                $('#star-rating').css('color', '#f4f2f2');
            }
        }

        $(document).ready(function() {
            var rating = parseInt($('#rating').html());
            star_display(rating);

            $('.follow_unfollow').click(function() {
                $('.follow_unfollow').attr('disabled', true);
                var val = $(this).html();
                if (val == '+ Follow') {
                    var follower_username = <?php echo "'".$_GET['u']."'"?>;
                    var type = 'follow';
                    $('.follow_unfollow').html('- Unfollow');
                    $('.follow_unfollow').delay(2500).attr('id', 'unfollow');
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
                    $('.follow_unfollow').html('+ Follow');
                    $('.follow_unfollow').delay(2500).attr('id', 'follow');
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
    $u = $_GET['u'];
    $sql = "SELECT uid FROM users WHERE username = '$u';";
    $result = mysqli_query($conn, $sql);
    $r = mysqli_fetch_assoc($result);
    $u_id = $r['uid'];

    $sql = "SELECT status FROM profile WHERE uid='$u_id';";
    $result = mysqli_query($conn, $sql);
    $r = mysqli_fetch_assoc($result);
    $status = $r['status'];
    if ($status == "") $status = 'uploads/user.png';
    
    echo '<div class="profile-img-profile"><img id="myprofile" style="height: 100%; width: 100%; object-fit: cover; z-index: 0;" src="'.$status.'"></div>';

    $sql = "SELECT * FROM profile, users WHERE profile.uid='$u_id' AND users.username='$u';";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        echo '<span id="username">'.$row['username'].'</span>';
        if (isset($_SESSION['uid'])) {
            echo ' &#x25FE ';
            $user_id = $_SESSION['uid'];
            $sql = "SELECT * FROM following WHERE user_id='$user_id' AND follower_id='$u_id'";
            $result = $conn->query($sql);
            if ($_GET['u'] != $_SESSION['username']) {
                if ($result->num_rows < 1) {
                    echo '<span class="follow_unfollow" id="follow">+ Follow</span></br>';
                }
                else {
                    echo '<span class="follow_unfollow" id="unfollow">- Unfollow</span></br>';
                }
            }
            else {
                echo '<a href="profile"><button class="edit-button">Edit Profile</button></a></br>';
            }
        }
        else {
            echo '<br>';
        }
        $num_following = $conn->query("SELECT * FROM following WHERE user_id='$u_id'")->num_rows;
        $num_followers = $conn->query("SELECT * FROM following WHERE follower_id='$u_id'")->num_rows;
        /*$seller_query = $conn->query("SELECT * FROM transactions WHERE sellerID = '$u_id'");
        $buyer_query = $conn->query("SELECT * FROM transactions WHERE buyerID = '$u_id'");
        $num_rating = mysqli_num_rows($seller_query) + mysqli_num_rows($buyer_query);
        $seller_result = mysqli_fetch_assoc($seller_query);
        $buyer_result = mysqli_fetch_assoc($buyer_query);
        $rating_agg = $seller_result['target_rating'] + $buyer_result['user_rating'];
        if ($num_rating == 0) {
            $user_rating = 'N/A';
        }
        else {
            $user_rating = $rating_agg / $num_rating;
        }*/

        echo '<br>';
        echo '<span id="followers" onclick="follow_display(0)"><b id="followers_num">'.$num_followers.'</b> Followers</span><span id="following" onclick="follow_display(1)"><b id="following_num">'.$num_following.'</b> Following</span><br><br>'; // &#x25FE <span><b id="rating">'.$user_rating.'</b> <i id="star-rating" class="fas fa-star fa-2x" aria-hidden="true"></i></span>

        echo '<span id="fullname">'.$row['name'].'</span> &#x25FE <span id="biography">'.$row['bio'].'</span>';
    }
?>
</div>