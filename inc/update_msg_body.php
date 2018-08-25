<script type="text/javascript">
    $('.user').click(function() {
        clearTimeout(renewBody);
        //console.log('clearTimeout(renewBody)');
    });
</script>

<?php
    session_start();
    include '../dbh.php';
    include 'time.php';
    $uid = $_SESSION['uid'];
    $query = 'SELECT * FROM messages
    INNER JOIN
    (
      SELECT MAX(id) as id FROM ( 
        SELECT MAX(id) as id, u_to as contact
        FROM messages
        WHERE u_from ="'.$uid.'"
        GROUP BY u_to
        UNION ALL
        SELECT MAX(id) as id, u_from as contact
        FROM messages
        WHERE u_to="'.$uid.'"
        GROUP BY u_from
      ) t GROUP BY contact
    ) d
    ON messages.id = d.id
    ORDER BY time_sent DESC;';
    $result = mysqli_query($conn, $query);

    if (!mysqli_num_rows($result) > 0) {
        echo '<p id="no_inbox">No Inbox!</p>';
    }
    else {
        while ($row = mysqli_fetch_assoc($result)) {

            if ($row['opened'] == 1 || $row['u_from'] == $uid) {
                $class = '';
            }
            else {
                $class = 'fa fa-circle';
            }

            if ($row['u_to'] == $_SESSION['uid']) {
                $to_from = $row['u_from'];
                $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE uid = '$to_from';"));
                $to_from = $r['username'];
            }
            else {
                $to_from = $row['u_to'];
                $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE uid = '$to_from';"));
                $to_from = $r['username'];
            }
            $user = "'".$to_from."'";
            $chat_id = "'".$row['chat_id']."'";
            echo '<div class="user" onclick="show('.$user.', '.$chat_id.');">
            <i class="'.$class.'" id="'.$row['chat_id'].'"></i>
            <ul>
                <li><h2>'.$to_from.'</h2></li>';
            if ($row['message'] == '' && $row['pic_url'] != '') {
                echo '<li><p class="last_text">Image</p></li>';
            }
            else {
                echo '<li><p class="last_text">'.$row['message'].'</p></li>';
            }
            echo '</ul>
            <p class="time">'.getPostTime($row['time_sent']).'</p>
            </div>';
        }
    }
?>