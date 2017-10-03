<?php

    include 'dbh.php';

    $pwd =  mysqli_real_escape_string($conn, $_POST['pwd']);
    $cPwd =  mysqli_real_escape_string($conn, $_POST['cPwd']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $hash = mysqli_real_escape_string($conn, $_POST['hash']);
    $errorEmpty = false;
    $errorEmail = false;

    $data = $conn->query("SELECT uid FROM pwdrecovery WHERE email = '$email' AND hash = '$hash';");

    if (!isset($_POST['submit'])) {
        echo 'There was an error!';
    }
    else {
        if (empty($pwd) || empty($cPwd)) {
            echo "<span class='error'>Fill in all the fields!</span>";
            $errorEmpty = true;
        }
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<span class='error'>Enter valid E-mail!</span>";
            $errorEmail = true;
        }
        else {
            if ($pwd != $cPwd) {
                echo "<span class='error'>Enter same password.</span>";
            }
            else {
                if ($errorEmail && $errorEmpty) {
                    echo "<span class='error'>Error.</span>";
                }
                else {
                    if ($data->num_rows > 0) {
                        updateRecords($conn, $pwd, $email);
                    }
                    else {
                        echo "<span class='error'>Cannot change your password.</span>";
                    }
                }
            }
        }
    }

    function updateRecords($conn, $pwd, $email) {
        $sql = "UPDATE user_info SET u_pwd = '$pwd' WHERE u_email = '$email';";
        mysqli_query($conn, $sql);
        echo "<span class='success'>Password changed.</span>";
        
        $sql = "DELETE FROM pwdrecovery WHERE email = '$email';";
        mysqli_query($conn, $sql);
    }



?>