<?php
    include '../dbh.php';
    session_start();

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
    $pwd = md5($pwd);

    $sql = "SELECT * FROM users WHERE username='$username' OR email='$username';";
    $result = $conn->query($sql);
    $check = mysqli_num_rows($result);

    if($check < 1) {
        echo 'Username/Password incorrect.';
        die;
    }
    else {
        if($row = mysqli_fetch_assoc($result)) {
            if($row['pwd'] != $pwd) {
                echo 'Username/Password incorrect.';
                die;
            }
            elseif($row['pwd'] == $pwd) {
                $_SESSION['uid'] = $row['uid'];
                $_SESSION['fname'] = $row['first_name'];
                $_SESSION['lname'] = $row['last_name'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['pwd'] = $row['pwd'];
            }
        }
    }