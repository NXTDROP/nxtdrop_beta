<?php
    session_start();
    date_default_timezone_set("UTC"); 
    include '../../dbh.php';
    $date = date("Y-m-d H:i:s", time());
    $conn->autocommit(false);
    $addTalk = $conn->prepare("INSERT INTO talk (userID, message, date) VALUES (?, ?, ?);");
    $addTalk->bind_param('sss', $usedID, $text, $date);

    if (!isset($_SESSION['uid'])) {
        die('CONNECTION');
    }
    else {
        if(!isset($_POST['text'])) {
            die('TEXT');
        } else {
            $date = date("Y-m-d H:i:s", time());
            $text = $_POST['text'];
            $usedID = $_SESSION['uid'];
            if($addTalk->execute()) {
                $conn->commit();
                $json = array();

                $data = array(
                    'text' => $text,
                    'date' => $date,
                    'username' => $_SESSION['username']
                );
                            
                array_push($json, $data);

                $jsonstring = json_encode($json);
                die($jsonstring);
            } else {
                $conn->rollback();
                die('DB');
            }
        }
        
    }
?>