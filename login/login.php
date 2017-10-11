<?php
    include 'dbh.php';

    if(isset($_POST['submit'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

        $sql = "SELECT * FROM users WHERE username='$username' OR email='$username';";
        $result = $conn->query($sql);
        $check = mysqli_num_rows($result);
        if($check < 1) {
            $error = true;
        }
        else {
            if($row = mysqli_fetch_assoc($result)) {
                if($row['pwd'] != $pwd) {
                    $error = true;
                }
                elseif($row['pwd'] == $pwd) {
                    $_SESSION['uid'] = $row['uid'];
                    $_SESSION['fname'] = $row['first_name'];
                    $_SESSION['lname'] = $row['last_name'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['pwd'] = $row['pwd'];
                    header("Location: ../index.php?login=success");
                    exit();
                }
            }
        }
    }
?>