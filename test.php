<?php

session_start();
include 'dbh.php';
include('../credentials.php');
include('vendor/autoload.php');
include('email/Email.php');
date_default_timezone_set("UTC");
$purchaseDate = date("Y-m-d H:i:s", time());

/*$email = new Email('Yusuf', 'youssouphajr@gmail.com', 'orders@nxtdrop.com', 'ORDER SHIPPED!', '');
$email->setTransactionID('1');
$email->sendEmail('orderShipping');*/

$getUsers = $conn->prepare("SELECT username, email FROM users WHERE uid = 1000002");
$getUsers->execute();
$getUsers->bind_result($username, $email);
while($getUsers->fetch()) {
    $email3 = new Email($username, $email, 'support@nxdrop.com', 'Your last purchase attempt!', '');
    if($email3->sendEmail('checkoutError.php')) {
        echo $username.' DONE!';
    } else {
        echo $username.' ERROR!';
    }
}

$getUsers->close();

/*$email3 = new Email('Russia12345', 'cambellscustomhomes@gmail.com', 'orders@nxdrop.com', 'Hope you like your order!', '');
$email3->sendEmail('purchaseFollowUp');*/