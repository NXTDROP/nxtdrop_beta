<?php
    /*require_once('../credentials.php');*/
    $hostname = "160.153.75.102";
    $username = "testingvtwo";
    $password = "631297854mtc1997";
    $dbname = "users_beta";
    //$dbname = "nxtdrop_alpha_test";

    //Create connection to DB
    $conn = new mysqli($hostname, $username, $password, $dbname);
    //Check Connection
    if ($conn->connect_error) {
        printf("Connection Failed: %s\n", mysqli_connect_error());
        exit();
    }
?>