<?php
    session_start();
    include 'dbh.php';

    date_default_timezone_set("UTC"); 
    $caption = mysqli_real_escape_string($conn, $_POST['caption']);
    $date = date("Y-m-d H:i:s", time());

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    if (!isset($_SESSION['uid'])) {
        echo "You're not connected. Please log in.";
    }
    else {
        $uid = $_SESSION['uid'];
        if (empty($_FILES['file']['name'])) {
            echo "Upload Picture.";
        }
        else {
            if(in_array($fileActualExt, $allowed)) {
                if ($fileError === 0) {
                    if ($fileSize < 1000000) {
                        $fileNewName = $uid.uniqid('', true).".".$fileActualExt;
                        $fileDestination = 'uploads/p'.$fileNewName;
                        move_uploaded_file($fileTmpName, "../".$fileDestination);
                        $sql = "INSERT INTO posts (uid, caption, pic, pdate) VALUES ('$uid', '$caption', '$fileDestination', '$date');";
                        if (mysqli_query($conn, $sql)) {
                            echo "Posted!";
                            updateNumPosts($uid, $conn);
                        }
                        else {
                            echo "There was an error. Try later!";
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
    }

    function updateNumPosts($uid, $conn) {
        $sql = "SELECT posts FROM profile WHERE uid='$uid'";                                
        $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));
        $posts = $result['posts'] + 1;
        mysqli_query($conn, "UPDATE profile SET posts = '$posts' WHERE uid ='$uid';");
    }
?>