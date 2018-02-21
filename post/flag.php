<?php
    session_start();
    include '../dbh.php';
    date_default_timezone_set("UTC");
    $date = date("Y-m-d H:i:s", time());
    $pid = mysqli_real_escape_string($conn, $_POST['pid']);
    $posted_by = mysqli_real_escape_string($conn, $_POST['posted_by']);
    $flagged_by = $_SESSION['uid'];
    $result_query = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) FROM flag WHERE pid = $pid AND posted_by = $posted_by;"));

    if (!isset($_SESSION['uid'])) {
        die;
    }
    else {
        $r = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) FROM flag WHERE pid = '$pid' AND posted_by = '$posted_by' AND flagged_by = '$flagged_by';"));
        if ($r[0] > 0) {
            $sql = "INSERT INTO flag (pid, posted_by, flagged_by, time) VALUES ('$pid', '$posted_by', '$flagged_by', '$date');";
            if (mysqli_query($conn, $sql)) {
                $query = "SELECT COUNT(pid) FROM flag WHERE pid = $pid;";
                $qresult = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($qresult);
                $count = $row["COUNT(pid)"];
                if ($count >= 5) {
                    if (mysqli_query($conn, "INSERT flag ('pid', 'uid', 'caption', 'pic', 'likes', 'pdate') SELECT 'pid', 'uid', 'caption', 'pic', 'likes', 'pdate' FROM posts WHERE pid = $pid;")) {
                        mysqli_query($conn, "DELETE FROM posts WHERE pid = $pid;");
                    }
                }
            }
            else {
                die;
            }
        }
        else {
            die;
        }
    }
?>