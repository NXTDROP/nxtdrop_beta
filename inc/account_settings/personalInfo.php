<?php

    session_start();
    include '../../dbh.php';
    require_once('../../vendor/autoload.php');
    \Stripe\Stripe::setApiKey("sk_test_zFMuyMBC60raTKDdLGzR4wdb");

    $stripe_id = $_SESSION['stripe_acc'];
    $token = $_POST['token'];
    if($acct = \Stripe\Account::retrieve($stripe_id)) {
        $acct->account_token = $token;
        $acct->save();
    }
    else {
        echo 'Error 102. Contact Support team @ support@nxtdrop.com';
    }

?>