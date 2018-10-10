<?php
    session_start();
    date_default_timezone_set("UTC"); 
    include '../../dbh.php';
    require_once('atSystem.php');
    require_once('../time.php');
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
                $sdate = $date;
                $date = new DateTime($sdate);
                $date = $date->format('Y-m-d H:i:s');
                /*$m = convertAt($text);
                $raw = explode(",", $m);
                $message = $raw[0];
                $username = $raw[1];*/

                $arr = convertAt($text);
                $message = $arr[0];
                $username = $arr[1];

                $data = array(
                    'text' => $message,
                    'date' => getPostTime($date),
                    'username' => $_SESSION['username'],
                    'target' => $username,
                    'sdate' => $sdate
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