<script src="js/msg_box.js"></script>
<?php
    session_start();
    include 'dbh.php';
    $to_from = $_POST['to_from'];
    $username = $_SESSION['username'];
    $chat_id = md5($to_from.''.$_SESSION['username']);
    $sql = "SELECT * FROM messages WHERE chat_id = '$chat_id' ORDER BY time_sent ASC LIMIT 15;";
    $result = mysqli_query($conn, $sql);
    echo '<div class="msg_box">
    <div class="msg_head"><p id="from"><a href="profile.php?u='.$to_from.'" id="u_tofrom">'.$to_from.'</a></p>
        <div class="close"><i class="fa fa-times" aria-hidden="true" title="Close Chat"></i></div>
    </div>
    <div class="msg_body" id="body">';
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['u_from'] == $username) {
            echo '<div class="msg_a">'.$row['message'].'</div>';
        }
        else {
            echo '<div class="msg_b">'.$row['message'].'</div>';
        }
    }
    echo '<div class="msg_insert"></div>
    </div>
    <textarea class="msg_input" placeholder="Enter Message..."></textarea>
    <i class="fa fa-paper-plane fa-lg" aria-hidden="true" onclick="send(false)"></i>
</div>';
?>

        
        <!--<div class="msg_box">
            <div class="msg_head"><p id="from"><a href="profile.php?u=user1">User 1</a></p>
                <div class="close"><i class="fa fa-times" aria-hidden="true" title="Close Chat"></i></div>
            </div>
            <div class="msg_body" id="body1">
                <div class="msg_a">Yoo! Wanna trade these Yeezy?</div>
                <div class="msg_b">Yeah sure man.</div>
                <div class="msg_insert1"></div>
            </div>
            <textarea class="msg_input" id="1" placeholder="Enter Message..."></textarea>
            <i class="fa fa-paper-plane fa-lg" aria-hidden="true" onclick="send(1)"></i>
        </div>-->