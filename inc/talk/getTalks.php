<?php

    session_start();
    require_once('../../dbh.php');
    require_once('atSystem.php');
    require_once('../time.php');
    $getTalks = $conn->prepare("SELECT * FROM (SELECT t.message, t.date, u.username, p.status FROM talk t, users u, profile p WHERE t.userID = u.uid AND u.uid = p.uid ORDER BY t.date DESC LIMIT ? OFFSET ?) as date ORDER BY date ASC;");
    $getTalks->bind_param('ii', $count, $offset);

    $count = $_POST['count'];
    $offset = $_POST['offset'];
    if($getTalks->execute()) {
        $getTalks->bind_result($message, $sdate, $username, $profilePic);
            echo '<div id="first"></div>';
        while($getTalks->fetch()) {
            $date = new DateTime($sdate);
            $date = $date->format('Y-m-d H:i:s');

            if($profilePic === '') {
                $profilePic = 'uploads/user.png';
            }

            if(isset($_SESSION['username']) && $username != $_SESSION['username']) {
                $class = 'class="ops"';
            } else {
                $class = '';
            }

            /*$m = convertAt($message);
            $raw = explode(",", $m);
            $message = $raw[0];*/

            $arr = convertAt($message);
            $message = $arr[0];
                
            echo '<div class="talk-msg">
                        <a href="u/'.$username.'" '.$class.'>@'.$username.'</a><span class="talk-time"> '.getPostTime($date).'</span><br>
                        <img src="'.$profilePic.'" alt="" title="'.$username.'"><span>'.$message.'</span>
                    </div>';
        }
            
        echo '<div id="last"></div>';
    } else {
        die('DB');
    }
?>