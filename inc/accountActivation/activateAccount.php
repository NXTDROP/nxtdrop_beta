<?php

    include '../../dbh.php';

    $email = $_POST['email'];

    $conn->autocommit(false);
    $getUsers = $conn->query("SELECT * FROM users WHERE email = '$email'");

    if($data = $getUsers->fetch_assoc()) {
        $uid = $data['uid'];

        $checkAcc = $conn->query("SELECT * FROM users  WHERE uid = '$uid' AND active_account = '1'");

        if(mysqli_num_rows($checkAcc) > 0) {
            $conn->rollback();
            die('DONE');
        } else {
            $activateAccount = $conn->query("UPDATE users SET active_account='1' WHERE email='$email';");
            if($activateAccount) {
                $conn->commit();
                die;
            } else {
                $conn->rollback();
                die('DB');
            }
        }
    } else {
        $conn->rollback();
        die('DB');
    }
?>