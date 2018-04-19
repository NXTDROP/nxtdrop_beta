<?php
    session_start();
    date_default_timezone_set("UTC"); 
    include '../../dbh.php';
    $date = date("Y-m-d H:i:s", time());

    if (!isset($_SESSION['uid'])) {
        echo 'ERROR 101!';
    }
    else {
        $user_id = $_SESSION['uid'];
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo 'Invalid Email Address. Try Another!';
        }
        else {
            $sql = "SELECT * FROM users WHERE email='$email';";
            $result = $conn->query($sql);

            if ($result->num_rows > 1) {
                echo 'Sorry! Your friend is already a user.';
            }
            else {
                $sql = "INSERT INTO invites (user_id, invite_email) VALUES ('$user_id', '$email')";

                if ($conn->query($sql)) {
                    echo 'Sent!';
                }
                else {
                    echo 'Error. Try Later!';
                }
            }
        }
    }
?>