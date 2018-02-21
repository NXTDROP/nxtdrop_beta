<?php
    session_start();
    date_default_timezone_set("UTC"); 
    include '../dbh.php';
    $date = date("Y-m-d H:i:s", time());

    $report = mysqli_real_escape_string($conn, $_POST['report']);
    $pid = $_POST['pid'];
    $uid = $_SESSION['uid'];

    if (!isset($_SESSION['uid'])) {
        header("Location: login.php");
    }
    else {
        if ($report == '') {
            echo 'Your report is empty.';
        }
        else {
            if (substr_count($report, ' ') === strlen($report)) {
                echo 'Your report is empty.';
            }
            else {
                if (strlen($report) > 255 || strlen($report) <= 0) {
                    echo 'Your report is too long.';
                }
                else {
                    if (!isset($pid)) {
                        echo 'Error! Try later.';
                    }
                    else {
                        $query = "INSERT INTO reports (pid, uid, report, date) VALUES ('$pid', '$uid', '$report', '$date');";
                        if (!mysqli_query($conn, $query)) {
                            echo 'Cannot send your report.';
                        }
                    }
                }
            }
        }
    }
?>