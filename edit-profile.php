<?php 
    include 'dbh.php';
    session_start();

    if (isset($_SESSION['uid'])) {
        $query = "SELECT bio FROM profile WHERE uid=".$_SESSION['uid'].";";
        $result = mysqli_query($conn, $query);
        $r = mysqli_fetch_assoc($result);
        $bio = $r['bio'];
        
        if (isset($_POST['change-pwd'])) {
            $opwd = md5(mysqli_real_escape_string($conn, $_POST['opwd']));
            $pwd = $_SESSION['pwd'];
            if ($opwd != $pwd) {
                echo "<span class='error'>Current Password does not match!</span>";
            }
            else {
                $npwd = md5(mysqli_real_escape_string($conn, $_POST['npwd']));
                $cpwd = md5(mysqli_real_escape_string($conn, $_POST['cpwd']));

                if ($npwd != $cpwd) {
                    echo "<span class='error'>Enter same password.</span>";
                }
                else {
                    updatePassword($conn, $npwd, $_SESSION['email']);
                }
            }
        }

        if (isset($_POST['submit'])) {
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $bio = mysqli_real_escape_string($conn, $_POST['bio']);

            if (empty($email) || empty($username)) {
                echo "<span class='error'>Field all required fields!</span>";
            }
            else {
                $sql = "SELECT username FROM users WHERE username = '$username';";
                $result = $conn->query($sql);
                $check = mysqli_num_rows($result);
                if ($check < 1) {
                    updateRecords($conn, $name, $email, $username, $bio);   
                }
                else {
                    if ($username == $_SESSION['username']) {
                        updateRecords($conn, $name, $email, $username, $bio);   
                    }
                    else {
                        echo "<span class='error'>Username already used!</span>";
                    }
                }
                $uid = $_SESSION['uid'];
                $sql = "SELECT * FROM users WHERE uid='$uid';";
                $result = $conn->query($sql);
                $check = mysqli_num_rows($result);
                $row = mysqli_fetch_assoc($result);
                $_SESSION['uid'] = $row['uid'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['pwd'] = $row['pwd'];
            }
        }
    }
    else {
        header("Location: login.php");
    }

    function updatePassword($conn, $pwd, $email) {
        $sql = "UPDATE users SET pwd = '$pwd' WHERE email = '$email';";
        mysqli_query($conn, $sql);
        echo "<span class='success'>Password changed.</span>";
    }

    function updateRecords($conn, $name, $email, $username, $bio) {
        $uid = $_SESSION['uid'];
        $sql = "UPDATE users SET name = '$name', email = '$email', username = '$username' WHERE uid = '$uid';";
        $sql2 = "UPDATE profile SET bio = '$bio' WHERE uid = '$uid';";
        mysqli_query($conn, $sql);
        mysqli_query($conn, $sql2);
        echo "<span class='success'>Changes saved!</span>";
    }
?>
<!DOCTYPE html>

<html>
    <head>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-546WBVB');</script>
<!-- End Google Tag Manager -->
        <title>
            Edit Your Profile - NXTDROP - Canada's #1 Sneaker Marketplace
        </title>
        <link rel="canonical" href="https://nxtdrop.com/edit_profile">
        <base href="https://nxtdrop.com/">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link type="text/css" rel="stylesheet" href="edit-profile.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script>
            function previewImage (input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#profile_picture').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            function remove() {
                $('#change_pp').css('display', 'none');
            }

            $(document).ready(function() {
                $('.inputfile').change(function() {
                    previewImage(this);
                    $('#change_pp').css('display', 'block');
                });

                $('#change_pp').click(function() {
                    var file_data = $('.inputfile').prop('files')[0];
                    var form_data = new FormData();                     // Create a form
                    form_data.append('file', file_data);           // append file to form
                    $.ajax({
                        url: "inc/upload-profile-picture.php",
                        type: 'POST',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,                         
                        success: function(data){
                            $('#change_pp').css('background-color', 'green');
                            $('#change_pp').html('New Profile Picture Saved');
                            timeoutID = window.setTimeout(remove, 10000);
                            console.log(data);
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                });
            });
        </script>
    </head>

    <body>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-546WBVB"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
        <header>
            <a href="home"><img id ="logo"src="img/nxtdroplogo.png" width="125px"></a>
        </header>
        
        <div class="container">
            <form action="" method="POST" class="login-form">
                <h2>Profile Info</h2>
                <input type="text" name="name" placeholder="First Name" value="<?php if (isset($_SESSION['uid'])) echo $_SESSION['name'];?>"></br>
                <input type="text" name="email" placeholder="Email" value="<?php if (isset($_SESSION['uid'])) echo $_SESSION['email'];?>"required></br>
                <input type="text" name="username" placeholder="Username" value="<?php if (isset($_SESSION['uid'])) echo $_SESSION['username'];?>"required></br>
                <textarea name="bio" placeholder="Bio"><?php if (isset($_SESSION['uid'])) echo $bio; ?></textarea></br>
                <button type="submit" name="submit" id="submit">Save Changes</button></br></br>
            </form>
            <h2>Current Profile Picture</h2>
                <?php
                    $uid = $_SESSION['uid'];
                    $sql = "SELECT * FROM profile WHERE uid = $uid;";
                    $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));
                    if ($result['status'] == '') {
                        echo '<img id="profile_picture" src="https://nxtdrop.com/uploads/user.png"></br>';
                    }
                    else {
                        echo '<img id="profile_picture" src="https://nxtdrop.com/'.$result['status'].'"></br>';
                    }
                    ?>
                <input type="file" name="file" id="file" class="inputfile" accept="image/*" data-multiple-caption="{count} files selected" multiple />
                <label for="file" title="Change Profile Picture"><i class="fa fa-picture-o" aria-hidden="true"></i></label></br>
                <button id="change_pp">Save New Profile Picture</button></br>
            <form action="" method="POST" class="change-pwd-form">
                <h2>Change Password</h2>
                <input type="password" name="opwd" placeholder="Enter Old Password" required></br>
                <input type="password" name="npwd" placeholder="Enter New Password" required></br>
                <input type="password" name="cpwd" placeholder="Confirm Password" required></br>
                <button type="submit" name="change-pwd" id="change-pwd">Change Password</button>
            </form>
            </br></br>
            <a href="u/<?php echo $_SESSION['username'];?>"><p>Back to Profile</p></a>
        </div>
    </body>
</html>