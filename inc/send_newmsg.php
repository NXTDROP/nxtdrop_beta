<?php

    session_start();
    date_default_timezone_set("UTC"); 
    include 'dbh.php';
    $date = date("Y-m-d H:i:s", time());

    $to = $_POST['to'];
    $msg = $_POST['msg'];
    $from = $_SESSION['username'];

    $query = "SELECT username FROM users WHERE username = '$to';";
    $result = mysqli_query($conn, $query);
    $row = mysqli_num_rows($result);

    if (!isset($_SESSION['uid'])) {
        header('Location: ../index.php');
    }
    else {
        if ($to == "") {
            echo 'Enter a name';
        }
        else {
            if ($row < 1) {
                echo "Username does not exist!";
            }
            else {
                if ($msg == "") {
                    echo 'Enter a message';
                }
                else {
                    $query = "INSERT INTO messages (u_to, u_from, message, time_sent) VALUES ('$to', '$from', '$msg', '$date');";
                    if (!mysqli_query($conn, $query)) {
                        echo 'Cannot send your message.';
                    }
                }
            }
        }
    }
?>