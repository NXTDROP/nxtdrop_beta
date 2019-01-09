<?php
    require_once('../credentials.php');

    if(!isset($_SESSION['uid'])) {
        rememberMe();
    }

    function rememberMe() {
        $cookie = isset($_COOKIE['rememberme']) ? $_COOKIE['rememberme'] : '';
        if ($cookie) {
            list ($user, $token, $mac) = explode(':', $cookie);
            if (!hash_equals(hash_hmac('sha256', $user . ':' . $token, SECRET_KEY), $mac)) {
                return false;
            }
            $usertoken = fetchTokenByUserName($user);
            //echo 'token: '.$token.' , usertoken: '.$usertoken.', cookie: '.$_COOKIE['rememberme'];
            if (hash_equals($usertoken, $token)) {
                logUserIn($user);
            }
        }
    }

    function logUserIn($user) {
        include 'dbh.php';
        $sql = "SELECT * FROM users WHERE uid = $user";
        $result = $conn->query($sql);
        $check = mysqli_num_rows($result);

        if($row = mysqli_fetch_assoc($result)) {
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

            onLogin($uid);
        }
    }

    function onLogin($user) {
        require_once('../credentials.php');
        $token = random_bytes(16); // generate a token, should be 128 - 256 bit
        storeTokenForUser($user, $token);
        $cookie = $user . ':' . $token;
        $mac = hash_hmac('sha256', $cookie, SECRET_KEY);
        $cookie .= ':' . $mac;
        setcookie('rememberme', $cookie, time() + (86400 * 30), "/");
    }

    function storeTokenForUser($user, $token) {
        include 'dbh.php';
        date_default_timezone_set("UTC"); 
        $date = date("Y-m-d H:i:s", time());
        $sql = "SELECT * FROM rememberMe WHERE uid = $user";
        $result = $conn->query($sql);
        $check = mysqli_num_rows($result);
        if($check > 0) {
            $sql = "UPDATE rememberMe SET token = '$token', date = '$date' WHERE uid = $user";
            mysqli_query($conn, $sql);
        } else {
            $sql = "INSERT INTO rememberMe (uid, token, date) VALUES ('$user', '$token', '$date')";
            mysqli_query($conn, $sql);
        }
    }

    function fetchTokenByUserName($user) {
        include('dbh.php');
        $sql = "SELECT * FROM rememberMe WHERE uid = $user";
        $result = $conn->query($sql);
        $data = mysqli_fetch_assoc($result);
        return $data['token'];
    }
?>