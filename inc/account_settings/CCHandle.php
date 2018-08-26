<?php

    session_start();
    include '../../dbh.php';
    require_once('../../vendor/autoload.php');
    date_default_timezone_set("UTC");
    $date = date("Y-m-d H:i:s", time());
    \Stripe\Stripe::setApiKey("sk_test_zFMuyMBC60raTKDdLGzR4wdb");

    $stripe_id = $_SESSION['stripe_acc'];
    $token = $_POST['token'];
    if($acct = \Stripe\Account::retrieve($stripe_id)) {
        $query = "SELECT * FROM thebag WHERE stripe_id = '$stripe_id';";
        $result = $conn->query($query);
        if(mysqli_num_rows($result) > 0) {
            $query = "UPDATE thebag SET out_token = '$token', o_date = '$date' WHERE stripe_id = '$stripe_id'";
            if (!$conn->query($query)) {
               echo 'Could not update your payment method. Try later or contact support@nxtdrop.com'; 
            }
        }
        else {
            $uid = $_SESSION['uid'];
            $query = "INSERT INTO thebag (uid, stripe_id, out_token, o_date) VALUES ('$uid', '$stripe_id', '$token', '$date')";
            if (!$conn->query($query)) {
                echo 'ERROR. Could not add your payment method. Try later or contact support@nxtdrop.com'; 
            }
        }
    }
    else {
        echo 'Error 102. Contact Support team @ support@nxtdrop.com';
    }

?>