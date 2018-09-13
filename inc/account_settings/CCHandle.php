<?php

    session_start();
    include '../../dbh.php';
    require_once('../../../credentials.php');
    require_once('../../vendor/autoload.php');
    date_default_timezone_set("UTC");
    $date = date("Y-m-d H:i:s", time());
    \Stripe\Stripe::setApiKey($STRIPE_LIVE_SECRET_KEY);

    if(isset($_SESSION['uid'])) {
        $stripe_id = $_SESSION['stripe_acc'];
        $cus_id = $_SESSION['cus_id'];
        $token = $_POST['token'];
        if($cus = \Stripe\Customer::retrieve($cus_id)) {
            $query = "SELECT * FROM thebag WHERE stripe_id = '$stripe_id';";
            $result = $conn->query($query);
            if(mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                if($card = $cus->sources->create(array("source" => $token))) {
                    $cardID = $card->id;
                    if($row['out_token'] != "") $cus->sources->retrieve($row['out_token'])->delete();

                    $query = "UPDATE thebag SET out_token = '$cardID', o_date = '$date' WHERE stripe_id = '$stripe_id'";
                    if (!$conn->query($query)) {
                        echo 'We cannot update your payment method right now. Try later or contact support@nxtdrop.com'; 
                    }
                }
                else {  
                    echo 'We cannot update your payment method right now. Try later or contact support@nxtdrop.com';
                }
            }
            else {
                $uid = $_SESSION['uid'];
                $card = $cus->sources->create(array("source" => $token));
                $cardID = $card->id;
                $query = "INSERT INTO thebag (uid, stripe_id, out_token, o_date) VALUES ('$uid', '$stripe_id', '$cardID', '$date')";
                if (!$conn->query($query)) {
                    echo 'Could not add your payment method. Try later or contact support@nxtdrop.com'; 
                }
            }
        }
        else {
            echo 'Contact Support team @ support@nxtdrop.com';
        }  
    }
    else {
        header("location: https://nxtdrop.com");
    }
?>