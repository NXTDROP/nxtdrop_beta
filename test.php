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


/*$email2 = new Email('momarcissex', 'momar@nxtdrop.com', 'orders@nxdrop.com', 'YOUR ORDER IS ARRIVING!', '');
$email2->setTransactionID('1');
$email2->sendEmail('sellerShipping');*/

$email3 = new Email('Russia12345', 'cambellscustomhomes@gmail.com', 'orders@nxdrop.com', 'YOUR ORDER IS ARRIVING!', '');
$email3->setTransactionID('1');
$email3->sendEmail('sellerShipping');