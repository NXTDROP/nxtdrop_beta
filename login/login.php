<?php
    include 'dbh.php';

    if(isset($_POST['submit'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

        $sql = "SELECT * FROM user_info WHERE username='$username' OR u_email='$username';";
        $result = $conn->query($sql);
        $check = mysqli_num_rows($result);
        if($check < 1) {
            $error = true;
        }
        else {
            if($row = mysqli_fetch_assoc($result)) {
                if($row['u_pwd'] != $pwd) {
                    $error = true;
                }
                elseif($row['u_pwd'] == $pwd) {
                    $_SESSION['uid'] = $row['uid'];
                    $_SESSION['u_fname'] = $row['u_fname'];
                    $_SESSION['u_lname'] = $row['u_lname'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['u_email'] = $row['u_email'];
                    $_SESSION['u_pwd'] = $row['u_pwd'];
                    header("Location: index.php?login=success");
                    exit();
                }
            }
        }
    }
?>