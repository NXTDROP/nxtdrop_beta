<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "loginsystem_test";

    //Create connection to DB
    $conn = new sqli($hostname, $username, $password, $dbname);

    //Check Connection
    if ($conn->connect_error) {
        die("Connection Failed:" . $conn->connection_error);
    }
    else {
        /*echo "Successfully connected!";*/
    }
?>