<?php

    include '../dbh.php';
    date_default_timezone_set("UTC"); 
    $date = date("Y-m-d H:i:s", time());

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $uName = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
    $errorEmpty = false;
    $errorEmail = false;
    $errorUsername = false;

    if(isset($_POST['submit'])) {
        if(empty($name) || empty($lName) || empty($uName) || empty($email) || empty($pwd)) {
            echo "Fill in all the fields!";
            $errorEmpty = true;
        }
        /*elseif(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<span class='error'>Enter valid E-mail!</span>";
            $errorEmail = true;
        }*/
    }
    else {
        echo "There was an error!";
    }

    $sql = "SELECT email FROM users WHERE email = '$email';";
    $result = $conn->query($sql);
    $check = mysqli_num_rows($result);
    if($check > 0) {
        echo "E-mail already used!";
        $errorEmail = true;
    }

    $sql = "SELECT username FROM users WHERE username = '$uName';";
    $result = $conn->query($sql);
    $check = mysqli_num_rows($result);
    if ($check > 0) {
        echo "Username already used!";
        $errorUsername = true;
    }

    if($errorEmpty == false && $errorEmail == false && $errorUsername == false) {
        $pwd = md5($pwd);
        $sql = "INSERT INTO users (name, username, email, pwd, account_created) VALUES ('$name', '$uName', '$email', '$pwd', '$date');";
        if (mysqli_query($conn, $sql)) {
            $sql = "SELECT uid FROM users WHERE username = '$uName';";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $uid = $row['uid'];
            $q = "INSERT INTO profile (uid) VALUES ('$uid');";
            mysqli_query($conn, $q);
            include '../welcome.php';
            
            session_start();
            $_SESSION['uid'] = $uid;
            $_SESSION['name'] = $name;
            $_SESSION['username'] = $uName;
            $_SESSION['email'] = $email;
            $_SESSION['pwd'] = $pwd;
            date_default_timezone_set("UTC"); 
            $date = date("Y-m-d H:i:s", time());
            $uid = $_SESSION['uid'];
            $sql = "UPDATE users SET last_connected = '$date' WHERE uid = '$uid'";
            mysqli_query($conn, $sql);
        }
        else {
            echo "Error. Try Later!";
        }
    }

?>