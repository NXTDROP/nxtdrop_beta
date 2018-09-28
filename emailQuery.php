<?php

    require_once('../credentials.php');
    include('vendor/autoload.php');
    include('email/Email.php');
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

    $conn->autocommit(false);
    
    $getUsers = $conn->query("SELECT raffle.email AS email, users.username AS username FROM users, raffle WHERE raffle.email = users.email;");

    while($data = $getUsers->fetch_assoc()) {
        $subject = 'And the Winner is...';
        $email = new Email($data['username'], $data['email'], 'hello@nxtdrop.com', $subject, '');
        if($email->sendEmail('giveaway') === 'false') {
            echo $data['username'].' FAILED!<br>';
        } else {
            echo $data['username'].' DONE!<br>';
        }
    }

?>