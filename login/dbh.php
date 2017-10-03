<?php
    $hostname = "localhost";
    $username =  "root";
    $password = "";
    $dbname = "loginsystem_test";

    //Create Connection
    $conn = new mysqli($hostname, $username, $password, $dbname);

    //Check Connection
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }
    else {
        /*echo "Connected successfully";*/
    }
?>