<?php

    session_start();
    $db = '../../dbh.php';
    include $db;
    include('../../../credentials.php');
    include('../../vendor/autoload.php');
    include('../../email/Email.php');
    date_default_timezone_set("UTC");
    $date = date("Y-m-d H:i:s", time());
    $conn->autocommit(FALSE);

    $item_ID = $_POST['itemID'];
    $size = $_POST['size'];
    $n_id = $_SESSION['uid'];

    if(!isset($_SESSION['uid'])) {
        die('CONNECT');
    }
    else {

        $addTransaction = $conn->prepare("INSERT INTO holidayTransactions (itemID, buyerID, size, date) VALUES (?, ?, ?, ?);");
        $addTransaction->bind_param("iids", $item_ID, $n_id, $size, $date);

        if($addTransaction->execute()) {
            $conn->commit();
            die('GOOD');
        }
        else {
            $conn->rollback();
            die('DB');
        }
    }

    function errorLog($e) {
        $log_filename = $_SERVER['DOCUMENT_ROOT']."/log";

        $body = $e->getJsonBody();
        $err  = $body['error'];
        $log = 'Status is:' . $e->getHttpStatus() . "\n" . 'Type is:' . $err['type'] . "\n" . 'Code is:' . $err['code'] . "\n" . 'Message is:' . $err['message'] . "\n" . 'Date:' . date("Y-m-d H:i:s", time());

        if (!file_exists($log_filename))
        {
            // create directory/folder uploads.
            mkdir($log_filename, 0777, true);
        }
        $log_file_data = $log_filename.'/log_' . date('d-M-Y') . '.log';
        file_put_contents($log_file_data, $log . "\n", FILE_APPEND);
    }

?>