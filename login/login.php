<?php
    include '../dbh.php';
    session_start();

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
    $pwd = md5($pwd);

    $sql = "SELECT * FROM users WHERE (blocked = '0' AND active_account = '1' AND email = '$username') OR (username = '$username' AND blocked = '0' AND active_account = '1')";
    $result = $conn->query($sql);
    $check = mysqli_num_rows($result);

    if($check < 1) {
        echo 'Username/Password incorrect OR Activate your Account.';
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
                $_SESSION['name'] = $row['name'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['stripe_acc'] = $row['stripe_id'];
                $_SESSION['cus_id'] = $row['cus_id'];
                $_SESSION['country'] = $row['country'];
                date_default_timezone_set("UTC"); 
                $date = date("Y-m-d H:i:s", time());
                $uid = $_SESSION['uid'];
                $sql = "UPDATE users SET last_connected = '$date' WHERE uid = '$uid'";
                mysqli_query($conn, $sql);

                if(isset($_SESSION['rdURL'])) {
                    die('redirect');
                }

                $q = "SELECT * FROM preferences WHERE userID = $uid;";
                $r = $conn->query($q);
                $c = mysqli_num_rows($r);

                if($c < 1) {
                    die('preferences');
                }
            }
        }
    }