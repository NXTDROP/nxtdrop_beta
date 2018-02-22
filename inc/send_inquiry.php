<?php
    session_start();
    date_default_timezone_set("UTC"); 
    include '../dbh.php';
    $date = date("Y-m-d H:i:s", time());

    $report = mysqli_real_escape_string($conn, $_POST['report']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);

    if ($report == '') {
        echo 'Your report is empty.';
    }
    else {
        if (substr_count($report, ' ') === strlen($report)) {
            echo 'Your report is empty.';
        }
        else {
            if (strlen($report) > 16000000 || strlen($report) <= 0) {
                echo 'Your report is too long.';
            }
            else {
                $query = "INSERT INTO inquiry (username, report, date) VALUES ('$username', '$report', '$date');";
                if (!mysqli_query($conn, $query)) {
                    echo 'Cannot send your report.';
                }
            }
        }
    }
?>