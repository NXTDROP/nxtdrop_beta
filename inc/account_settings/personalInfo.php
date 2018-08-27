<?php

    session_start();
    include '../../dbh.php';
    require_once('../../vendor/autoload.php');
    date_default_timezone_set("UTC");
    $date = date("Y-m-d H:i:s", time());
    \Stripe\Stripe::setApiKey("sk_test_zFMuyMBC60raTKDdLGzR4wdb");

    if(isset($_SESSION['uid'])) {
        $stripe_id = $_SESSION['stripe_acc'];
        $token = $_POST['token'];
        $address = $_POST['address'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $uid = $_SESSION['uid'];
        if($acct = \Stripe\Account::retrieve($stripe_id)) {
            $acct->account_token = $token;
            $acct->save();
            $query = "SELECT * FROM thebag WHERE stripe_id = '$stripe_id'";
            $result = $conn->query($query);
            if(mysqli_num_rows($result) > 0) {
                $query = "UPDATE thebag SET first_name = '$first_name', last_name = '$last_name', address = '$address', personalInfoLastUpdate = '$date' WHERE stripe_id = '$stripe_id'";
                if(!$conn->query($query)) {
                    echo 'We are unable to update your personal information. Try later or contact us @ support@nxtdrop.com';
                }
            }
            else {
                $query = "INSERT INTO thebag (uid, stripe_id, first_name, last_name, address, personalInfoLastUpdate) VALUES ('$uid', '$stripe_id', '$first_name', '$last_name', '$address', '$date')";
                if(!$conn->query($query)) {
                    echo 'We are unable to update your personal information. Try later or contact us @ support@nxtdrop.com';
                }
            }
        }
        else {
            echo 'Error 102. Contact our support team @ support@nxtdrop.com';
        }
    }
    else {
        header("location: https://nxtdrop.com");
    }
?>