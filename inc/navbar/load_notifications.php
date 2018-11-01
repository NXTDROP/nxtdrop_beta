<?php
    session_start();
    $db = '../../dbh.php';
    include $db;
    include '../time.php';
    require_once('../currencyConversion.php');

    if (!isset($_SESSION['uid'])) {
        echo 'ERROR!';
    }
    else {
        $uid = $_SESSION['uid'];
        $sql = "SELECT * FROM notifications WHERE target_id = '$uid' OR middleman_id = '$uid' ORDER BY date DESC LIMIT 15";
        $result = $conn->query($sql);

        if (!mysqli_num_rows($result) > 0) {
            echo '<p>You have 0 notifications.</p>';
        }
        else {
            while($row = mysqli_fetch_assoc($result)) {
                $post_id = "'".$row['post_id']."'";
                $uid = $row['user_id'];


                if ($row['post_id'] == '0') {
                    $sql = "SELECT * FROM users, profile WHERE users.uid = '$uid' AND profile.uid = '$uid'";
                }
                elseif($row['notification_type'] === "middleman shipping" || $row['notification_type'] === "middleman verification") {
                    $sql = "SELECT * FROM posts, transactions WHERE posts.pid = $post_id AND transactions.itemID = posts.pid";
                }
                elseif($row['notification_type'] == 'mentioned') {
                    $sql = "SELECT talk.message, users.username, profile.status FROM talk, users, profile WHERE talk.talkID = $post_id AND talk.userID = users.uid AND profile.uid = users.uid";
                }
                elseif($row['notification_type'] == 'counter-offer') {
                    $sql = "SELECT users.username, profile.status, products.assetURL, products.model, offers.price, counterOffer.offer, offers.offerID, users.uid FROM offers, users, profile, products, counterOffer WHERE offers.offerID = $post_id AND counterOffer.userID = users.uid AND counterOffer.offerID = offers.offerID AND profile.uid = users.uid AND offers.productID = products.productID";
                }
                elseif($row['notification_type'] == 'item sold') {
                    $sql = "SELECT users.username, users.uid, profile.status, products.assetURL, products.model, offers.offerID, offers.size, offers.price FROM offers, users, profile, products, transactions WHERE offers.offerID = $post_id AND transactions.buyerID = users.uid AND transactions.itemID = offers.offerID AND profile.uid = users.uid AND offers.productID = products.productID LIMIT 1;";
                }
                else {
                    $sql = "SELECT * FROM posts, users, profile WHERE posts.pid = $post_id AND profile.uid = $uid AND users.uid = $uid";
                }

                $r = $conn->query($sql);
                $user_result = mysqli_fetch_assoc($r);

                $date = getPostTime($row['date']);

                if (isset($user_result['status']) && $user_result['status'] == '') {
                    $user_result['status'] = "uploads/user.png";
                }

                if ($row['viewed'] == 0) {
                    $background = 'style="background:#ffc1c1"';
                }
                else {
                    $background = '';
                }
    
                if($row['notification_type'] == 'like') {
                    echo '<div class="one_notif" onclick="go_to_post('.$post_id.')" '.$background.'><img src="'.$user_result['status'].'" alt="" class="profile_notif"><span class="message_notif"><a href="u/'.$user_result['username'].'" id="notif_user">'.$user_result['username'].'</a> liked your post. <span class="notif_time">'.$date.'</span></span><img src="'.$user_result['pic'].'" alt="" class="post_img"></div>';
                }
                else if($row['notification_type'] == 'follow') {
                    $username = "'".$user_result['username']."'";
                    echo '<div class="one_notif" onclick="go_to_profile('.$username.')" '.$background.'><img src="'.$user_result['status'].'" alt="" class="profile_notif"><span class="message_notif"><a href="u/'.$user_result['username'].'" id="notif_user">'.$user_result['username'].'</a> is now following you. <span class="notif_time">'.$date.'</span></span></div>';
                }
                else if($row['notification_type'] == 'confirmation') {
                    $username = "'".$user_result['username']."'";
                    echo '<div class="one_notif" onclick="confirmation('.$user_result['uid'].', '.$_SESSION['uid'].', '.$user_result['pid'].')" '.$background.'><img src="'.$user_result['status'].'" alt="" class="profile_notif"><span class="message_notif"><a href="u/'.$user_result['username'].'" id="notif_user">'.$user_result['username'].'</a> sold you an item. <span class="notif_time">'.$date.'</span></span></div>';
                }
                else if($row['notification_type'] == 'item sold') {
                    if($_SESSION['country'] == 'CA') {
                        $price = usdTocad($user_result['price'], $db, true);
                    } else {
                        $price = 'US$'.$user_result['price'];
                    }
                    $pic = "'".$user_result['assetURL']."'";
                    $description = "'".$user_result['model'].', Size: US'.$user_result['size'].', Price: '.$price."'";
                    $buyer_id = "'".$user_result['uid']."'";
                    echo '<div class="one_notif" onclick="order_confirmation('.$user_result['offerID'].', '.$pic.', '.$description.', '.$buyer_id.')" '.$background.'><img src="https://nxtdrop.com/img/nxtdroplogo.png" alt="" class="profile_notif"><span class="message_notif">Your item just sold! Click to confirm order. <span class="notif_time">'.$date.'</span></span><img src="'.$user_result['assetURL'].'" alt="" class="post_img"></div>';
                }
                else if($row['notification_type'] == 'middleman verification') {
                    $pic = "'".$user_result['assetURL']."'";
                    $description = "'".$user_result['model']."'";
                    $buyer_id = "'".$user_result['uid']."'";
                    echo '<div class="one_notif" onclick="order_verification('.$user_result['offerID'].', '.$pic.', '.$description.', '.$buyer_id.')" '.$background.'><span class="message_notif">&nbsp Item waiting for authentication. Click to send verification report. <span class="notif_time">'.$date.'</span></span><img src="'.$user_result['assetURL'].'" alt="" class="post_img"></div>';
                }
                else if($row['notification_type'] == 'middleman shipping' || $row['notification_type'] == 'seller shipping') {
                    $transactionID = "'".$user_result['transactionID']."'";
                    echo '<div class="one_notif" onclick="order_MMShipping('.$transactionID.')" '.$background.'><span class="message_notif">&nbsp Click/Tap to enter shipping information. <span class="notif_time">'.$date.'</span></span><img src="'.$user_result['pic'].'" alt="" class="post_img"></div>';
                }
                else if($row['notification_type'] == 'mentioned') {
                    echo '<div class="one_notif"  '.$background.'><img src="https://nxtdrop.com/'.$user_result['status'].'" alt="" class="profile_notif"><div class="message_notif">&nbsp <a href="'.$user_result['username'].'">@'.$user_result['username'].'</a> mentioned you: '.$user_result['message'].' &nbsp<span class="notif_time">'.$date.'</div></span></div>';
                }
                else if($row['notification_type'] == 'counter-offer') {
                    $model = $user_result['model'];
                    $model = str_replace("&apos;", '', $model);
                    $model = "'".$model."'";
                    echo '<div class="one_notif" onclick="counterOfferConf('.$user_result['price'].', '.$user_result['offer'].', '.$user_result['offerID'].', '.$user_result['uid'].', '.$model.')" '.$background.'><img src="'.$user_result['status'].'" alt="" class="profile_notif"><span class="message_notif">You received an offer for your '.$user_result['model'].' <span class="notif_time"> '.$date.'</span></span><img src="'.$user_result['assetURL'].'" alt="" class="post_img"></div>';
                }
                else {
                    echo '<div class="one_notif" onclick="go_to_inbox()" '.$background.'><img src="'.$user_result['status'].'" alt="" class="profile_notif"><span class="message_notif"><a href="u/'.$user_result['username'].'" id="notif_user">'.$user_result['username'].'</a> made you an offer. <span class="notif_time">'.$date.'</span></span><img src="'.$user_result['pic'].'" alt="" class="post_img"></div>';
                }
            }
        }
    }
?>