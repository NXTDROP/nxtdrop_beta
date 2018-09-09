<?php

    session_start();
    include '../../dbh.php';
    require_once('../../vendor/autoload.php');
    require_once('../../credentials.php');
    date_default_timezone_set("UTC");
    $date = date("Y-m-d H:i:s", time());

    if(!isset($_SESSION['uid'])) {
        echo 'CONNECT';
    }
    else {
        $email = $_SESSION['email'];
        $num = mysqli_num_rows($conn->query("SELECT * FROM raffle WHERE email = '$email'"));
        if($num > 0) {
            echo 'true';
        }
        else {
            echo 'false';
        }
    }

?>