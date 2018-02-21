<?php

    session_start();
    include '../dbh.php';

    if (isset($_SESSION['uid'])) {
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg', 'jpeg', 'png');
        $uid = $_SESSION['uid'];

        if (!empty($fileName)) {
            if(in_array($fileActualExt, $allowed)) {
                if ($fileError === 0) {
                    if ($fileSize < 1000000) {
                        $fileNewName = $uid.uniqid('', true).".".$fileActualExt;
                        $fileDestination = 'uploads/pp'.$fileNewName;
                        move_uploaded_file($fileTmpName, "../".$fileDestination);
                        $sql = "UPDATE profile SET status='$fileDestination' WHERE uid=$uid;";
                        if (mysqli_query($conn, $sql)) {
                            echo $fileDestination;
                        }
                        else {
                            echo 'error101';
                        }
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
            die;
        }
    }

?>