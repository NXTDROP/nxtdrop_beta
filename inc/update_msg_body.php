<?php
    session_start();
    include 'dbh.php';
    include 'time.php';
    $username = $_SESSION['username'];
    $query = 'SELECT * FROM messages
    INNER JOIN
    (
      SELECT MAX(id) as id FROM ( 
        SELECT MAX(id) as id, u_to as contact
        FROM messages
        WHERE u_from ="'.$username.'"
        GROUP BY u_to
        UNION ALL
        SELECT MAX(id) as id, u_from as contact
        FROM messages
        WHERE u_to="'.$username.'"
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

            if ($row['opened'] == 1 || $row['u_from'] == $username) {
                $class = '';
            }
            else {
                $class = 'fa fa-circle';
            }

            if ($row['u_to'] == $username) {
                $to_from = $row['u_from'];
            }
            else {
                $to_from = $row['u_to'];
            }
            $user = "'".$to_from."'";
            echo '<div class="user" onclick="show('.$user.');">
            <i class="'.$class.'" aria-hidden="true"></i>
            <ul>
                <li><h2>'.$to_from.'</h2></li>
                <li><p class="last_text">'.$row['message'].'</p></li>
            </ul>
            <p class="time">'.getPostTime($row['time_sent']).'</p>
            </div>';
        }
    }
?>