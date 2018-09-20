<?php
    /*require_once('../credentials.php');*/
    $hostname = "160.153.75.102";
    $username = "datadrop";
    $password = "(^@=t.Huu)FE";
    $dbname = "users_beta";

    //Create connection to DB
    $conn = new mysqli($hostname, $username, $password, $dbname);
    //Check Connection
    if ($conn->connect_error) {
        printf("Connection Failed: %s\n", mysqli_connect_error());
        exit();
    }
?>