<?php
    session_start();
    include 'dbh.php';
    $to_from = $_POST['to_from'];
    $username = $_SESSION['username'];
    $query = "SELECT DISTINCT chat_id FROM messages WHERE u_to = '$to_from' AND u_from = '$username' OR u_to = '$username' AND u_from = '$to_from';";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    $chat_id = $result['chat_id'];
    $sql = "SELECT * FROM (SELECT * FROM messages WHERE chat_id = '$chat_id' ORDER BY time_sent DESC LIMIT 15) AS date ORDER BY time_sent ASC;";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['u_from'] == $username) {
            echo '<div class="msg_a">'.$row['message'].'</div>';
        }
        else {
            echo '<div class="msg_b">'.$row['message'].'</div>';
            if ($row['opened'] == 0) {
                $id = $row['id'];
                mysqli_query($conn, "UPDATE messages SET opened='1' WHERE id='$id';");
            }
        }
    }
    echo '<div class="msg_insert"></div>';

?>