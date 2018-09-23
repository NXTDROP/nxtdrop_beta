<?php

    require_once('../credentials.php');
    $hostname = "160.153.75.102";
    $username = "datadrop";
    $password = "$DB_PASS";
    $dbname = "nxtdrop_alpha_test";

    //Create connection to DB
    $conn = new mysqli($hostname, $username, $password, $dbname);
    //Check Connection
    if ($conn->connect_error) {
        printf("Connection Failed: %s\n", mysqli_connect_error());
        exit();
    }

    include('vendor/autoload.php');

    include('email/Email.php');

    $conn->autocommit(false);
    $getUsers = $conn->query("SELECT email, username FROM users WHERE stripe_id = '' AND uid = '1000014';");

    while($data = $getUsers->fetch_assoc()) {
        $subject = 'Hi '.$data['username'].', we partnered with Stripe, Inc. & Silicon Valley Bank';
        $email = new Email($data['username'], $data['email'], 'hello@nxtdrop.com', $subject, '');
        if($email->sendEmail('stripeRegistration') === 'false') {
            echo $data['username'].' FAILED!<br>';
        } else {
            echo $data['username'].' DONE!<br>';
        }
    }

?>