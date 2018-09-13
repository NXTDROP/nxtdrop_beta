<?php
    require_once('../credentials.php');
    $hostname = "160.153.75.102";
    $username = "datadrop";
    $password = $DB_PASS;
    $dbname = "nxtdrop_alpha_test";

    //Create connection to DB
    $conn = new mysqli($hostname, $username, $password, $dbname);

    //Check Connection
    if ($conn->connect_error) {
        die("Connection Failed:".$conn->connection_error);
    }
    else {
        /*echo "Successfully connected!";*/
    }
?>