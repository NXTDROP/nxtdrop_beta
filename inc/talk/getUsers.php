<?php

    session_start();
    require_once('../../dbh.php');
    require_once('atSystem.php');
    require_once('../time.php');
    $getUsers = $conn->prepare("SELECT username FROM users;");

    if($getUsers->execute()) {
        $getUsers->bind_result($username);
        $json = array();
        $data = '[';
        while($getUsers->fetch()) {
            $data = array(
                'username' => $username
            );
                        
            array_push($json, $data);
        }

        $jsonstring = json_encode($json);
        die($jsonstring);
    }
?>