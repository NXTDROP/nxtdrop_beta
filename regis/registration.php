<?php

    include '../dbh.php';
    /*require_once('../vendor/autoload.php');
    \Stripe\Stripe::setApiKey("sk_test_zFMuyMBC60raTKDdLGzR4wdb");*/
    date_default_timezone_set("UTC"); 
    $date = date("Y-m-d H:i:s", time());

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $uName = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $errorEmpty = false;
    $errorEmail = false;
    $errorUsername = false;

    if(isset($_POST['submit'])) {
        if (empty($uName) || empty($email) || empty($pwd)) {
            echo "Fill in all the fields!";
            $errorEmpty = true;
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
            $sql = "INSERT INTO users (name, username, email, pwd, account_created, country) VALUES ('$name', '$uName', '$email', '$pwd', '$date', '$country')";
            if (mysqli_query($conn, $sql)) {
                $sql = "SELECT uid FROM users WHERE username = '$uName';";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $uid = $row['uid'];
                $q = "INSERT INTO profile (uid) VALUES ('$uid');";
                mysqli_query($conn, $q);
                /*include '../welcome.php';
                
                session_start();
                $_SESSION['uid'] = $uid;
                $_SESSION['name'] = $name;
                $_SESSION['username'] = $uName;
                $_SESSION['email'] = $email;
                $_SESSION['pwd'] = $pwd;
                $_SESSION['country'] = $country;

                $acct = \Stripe\Account::create(array(
                    "country" => "$country",
                    "type" => "custom", 
                    "email" => "$email",
                    "tos_acceptance" => array(
                        "date" => time(),
                        "ip" => $_SERVER['REMOTE_ADDR']
                    )
                ));

                $cus = \Stripe\Customer::create(array(
                    "email" => "$email",
                ));

                $cus_id = $cus->id;
                $account_id = $acct->id;
                
                $query = "UPDATE users SET stripe_id = '$account_id', cus_id = '$cus_id' WHERE uid = '$uid';";
                mysqli_query($conn, $query);*/
            }
            else {
                echo "Error. Try Later!";
            }
        }
    }
    else {
        echo "There was an error!";
    }
?>