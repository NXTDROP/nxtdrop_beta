<?php
    session_start();
    include '../dbh.php';
    $chat_id = $_POST['id'];
    
    if (isset($_POST['numData'])) {
        $numData = $_POST['numData'];
    }
    else {
        $numData = 15;
    }

    $sql = "SELECT * FROM (SELECT * FROM messages WHERE chat_id = '$chat_id' ORDER BY time_sent DESC LIMIT $numData) AS date ORDER BY time_sent ASC;";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['u_from'] == $_SESSION['uid']) {
            echo '<div class="msg_a">'.$row['message'].'</div>';
        }
        else {
            echo '<div class="msg_b">'.$row['message'].'</div>';
            if ($row['opened'] == 0 && $row['u_to'] == $_SESSION['uid']) {
                $id = $row['id'];
                mysqli_query($conn, "UPDATE messages SET opened='1' WHERE id='$id';");
            }
        }
    }
    echo '<div class="msg_insert"></div>';

?>