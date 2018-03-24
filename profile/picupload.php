<?php
    session_start();
    include '../dbh.php';

    if (isset($_POST['submit'])) {
        $uid = $_SESSION['uid'];

        $file = $_FILES['pp'];

        $fileName = $_FILES['pp']['name'];
        $fileTmpName = $_FILES['pp']['tmp_name'];
        $fileSize = $_FILES['pp']['size'];
        $fileError = $_FILES['pp']['error'];
        $fileType = $_FILES['pp']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png');

        if(in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 10000000) {
                    $fileNewName = $uid.".".$fileActualExt;
                    $fileDestination = '../uploads/profile'.$fileNewName;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    header("Location: ../index.php");
                }
                else {
                    echo 'Your file is too big!';
                }
            }
            else {
                echo 'There was an error uploading your file!';
            }
        }
        else {
            echo 'You cannot upload files of this type!';
        }
    }
    else {
        echo 'Error 23.';
    }
?>