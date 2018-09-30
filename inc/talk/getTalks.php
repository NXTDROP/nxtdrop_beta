<?php

    session_start();
    require_once('../../dbh.php');
    $getTalks = $conn->prepare("SELECT * FROM (SELECT t.message, t.date, u.username, p.status FROM talk t, users u, profile p WHERE t.userID = u.uid AND u.uid = p.uid ORDER BY t.date DESC LIMIT ? OFFSET ?) as date ORDER BY date ASC;");
    $getTalks->bind_param('ii', $count, $offset);

    if(!isset($_SESSION['uid'])) {
        die('CONNECTION');
    } else {
        $count = $_POST['count'];
        $offset = $_POST['offset'];
        if($getTalks->execute()) {
            $getTalks->bind_result($message, $date, $username, $profilePic);
            echo '<div id="first"></div>';
            while($getTalks->fetch()) {
                if($profilePic === '') {
                    $profilePic = 'uploads/user.png';
                }

                if($username != $_SESSION['username']) {
                    $class = 'class="ops"';
                } else {
                    $class = '';
                }
                
                echo '<div class="talk-msg">
                        <a href="u/'.$username.'" '.$class.'>'.$username.'</a><span class="talk-time">@ '.$date.'</span><br>
                        <img src="'.$profilePic.'" alt="" title="'.$username.'"><span>'.$message.'</span>
                    </div>';
            }
            
            echo '<div id="last"></div>';
        } else {
            die('DB');
        }
    }
?>