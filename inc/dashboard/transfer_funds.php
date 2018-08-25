<?php
    session_start();
    include '../../dbh.php';
    require_once('../../vendor/autoload.php');

    \Stripe\Stripe::setApiKey("sk_test_zFMuyMBC60raTKDdLGzR4wdb");
    $stripe_id = $_SESSION['stripe_acc'];
    $uid = $_SESSION['uid'];

    $balance = \Stripe\Balance::retrieve(array(
        'stripe_account' => $stripe_id
    ));

    $currency = strtolower($_POST['currency']);
    $transfer_type = $_POST['type'];
    $available_amount = $balance['available'][0]['amount'];

    if ($available_amount >= 0) {
        echo 'Your balance is US$0.00. You cannot initiate a transfer.';
    }
    else  {
        if ($currency == 'cad' && $transfer_type == 1) {
            echo 'Instant Payout is only available in the US. Please try Standard Payout.';
        }
        else {
            if ($transfer_type == 0) {
                $payout = \Stripe\Payout::create(array(
                    "amount" => $available_amount, 
                    "currency" => $currency
                ), array('stripe_account' => $stripe_id));
            }
            else {
                $payout = \Stripe\Payout::create(array(
                    "amount" => $available_amount, 
                    "currency" => $currency,
                    'method' => 'instant'
                ), array('stripe_account' => $stripe_id));
            }
        }
    }
?>