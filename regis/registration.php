<?php

    include '../dbh.php';

    $fName = mysqli_real_escape_string($conn, $_POST['fname']);
    $lName = mysqli_real_escape_string($conn, $_POST['lname']);
    $uName = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
    $errorEmpty = false;
    $errorEmail = false;
    $errorUsername = false;

    if(isset($_POST['submit'])) {
        if(empty($fName) || empty($lName) || empty($uName) || empty($email) || empty($pwd)) {
            echo "<span class='error'>Fill in all the fields!</span>";
            $errorEmpty = true;
        }
        /*elseif(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<span class='error'>Enter valid E-mail!</span>";
            $errorEmail = true;
        }*/
    }
    else {
        echo "There was an error!";
    }

    $sql = "SELECT email FROM users WHERE email = '$email';";
    $result = $conn->query($sql);
    $check = mysqli_num_rows($result);
    if($check > 0) {
        echo "<span class='error'>E-mail already used!</span>";
        $errorEmail = true;
    }

    $sql = "SELECT username FROM users WHERE username = '$uName';";
    $result = $conn->query($sql);
    $check = mysqli_num_rows($result);
    if ($check > 0) {
        echo "<span class='error'>Username already used!</span>";
        $errorUsername = true;
    }

    if($errorEmpty == false && $errorEmail == false && $errorUsername == false) {
        $pwd = md5($pwd);
        $sql = "INSERT INTO users (first_name, last_name, username, email, pwd) VALUES ('$fName', '$lName', '$uName', '$email', '$pwd');";
        if (mysqli_query($conn, $sql)) {
            $sql = "SELECT uid FROM users WHERE username = '$uName';";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $uid = $row['uid'];
            $q = "INSERT INTO profile (uid) VALUES ('$uid');";
            mysqli_query($conn, $q);
            echo "<span class='success'>Account Created!</span>";
            include '../welcome.php';
        }
        else {
            echo "<span class='error'>Error. Try Later!</span>";
        }
    }

?>

<script>

    $("#fName, #lName, #uName, #email, #pwd").removeClass("input-error");

    var errorEmpty = "<?php echo $errorEmpty; ?>";
    var errorEmail = "<?php echo $errorEmail; ?>";

    if(errorEmpty == true) {
        $("#fName, #lName, #uName, #email, #pwd").addClass("input-error");
    }
    if(errorEmail == true) {
        $("#email").addClass("input-error");
    }
    if(errorEmpty == false && errorEmail == false) {
        $("#fname, #lname, #username, #email, #pwd, #cpwd").val("");
    }

</script>