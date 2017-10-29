<?php
    include 'dbh.php';

    $confEmailError = false;
    $activate = false;

    if(isset($_POST['submit'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $sql = "SELECT * FROM users WHERE email='$email';";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $uid = $row['uid'];
        $hash = md5(rand(0,1000));

        if($result->num_rows > 0) {

            $nd_email = 'admin@nxtdrop.com';

            $subject = "Password Change Request";

            $headers = "From: " . $nd_email . "\r\n";
            $headers .= "Reply-To: " . $nd_email . "\r\n";
            $headers .= "CC: momar@nxtdrop.com";

            $message = 'Please click the link below to change your password: http://localhost/nd-v1.00/pwd.rec/newpwd.php?email='.$email.'&hash='.$hash.'';

            if (mail($email, $subject, $message, $headers)) {
                updateRecords($conn, $uid, $email, $hash);
                echo 'Email Sent';
            }
            else {
                echo 'Failed to send email';
                exit();
            }

        }
        else {
            $confEmailError =  true;
        }
        
        $activate = true;
    }

    function updateRecords($conn, $uid, $email, $hash) {
        $sql = "SELECT * FROM pwdrecovery WHERE email='$email';";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $sql = "UPDATE pwdrecovery SET hash = '$hash' WHERE uid = '$uid';";
            mysqli_query($conn, $sql);
            //echo 'Records updated';
        }
        else if ($result->num_rows < 1) {
            $sql = "INSERT INTO pwdrecovery (uid, email,hash) VALUES ('$uid', '$email', '$hash');";
            mysqli_query($conn, $sql);
            //echo 'Records updated';
        }
        else {
            echo 'Failed to update records';
        }
    }


?>