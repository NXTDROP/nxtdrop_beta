<div class="posts-container">
    <?php
        include '../dbh.php';
        include 'time.php';
        $sql = "SELECT * FROM users WHERE username = '".$_GET['u']."';";
        $result = mysqli_query($conn, $sql);
        $r = mysqli_fetch_assoc($result);
        $u_id = $r['uid'];

        $sql = "SELECT * FROM transactions WHERE user_ID = '$u_id' OR target_ID = '$u_id'";
        $result = $conn->query($sql);

        if (mysqli_num_rows($result) < 1) {
            echo '<p id="no_post">No Reviews Available!</p>';
        }
        else {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['user_ID'] == $u_id) {
                    $num_stars = $row['target_rating'];
                    echo '<div class="review_content"><p><b>"</b>'.$row['target_comment'].'<b>"</b></p>';
                    echo '<ul class="rating_stars">';
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $num_stars) {
                            echo '<li><i class="fa fa-star fa-2x" aria-hidden="true" id="gold_star"></i></li>';
                        }
                        else {
                            echo '<li><i class="fa fa-star-o fa-2x" aria-hidden="true"></i></li>';
                        }
                    }
                    echo '</ul></div>';
                }
                else {
                    $num_stars = $row['target_rating'];
                    echo '<div class="review_content"><p><b>"</b>'.$row['user_comment'].'<b>"</b></p>';
                    echo '<ul class="rating_stars">';
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $num_stars) {
                            echo '<li><i class="fa fa-star fa-2x" aria-hidden="true" id="gold_star"></i></li>';
                        }
                        else {
                            echo '<li><i class="fa fa-star-o fa-2x" aria-hidden="true"></i></li>';
                        }
                    }
                    echo '</ul></div>';
                }
            }
        }
    ?>
</div>