<div class="container-top">
<?php

    $sql = "SELECT uid FROM users WHERE username = '".$_GET['u']."';";
    $result = mysqli_query($conn, $sql);
    $r = mysqli_fetch_assoc($result);
    $u_id = $r['uid'];

    $sql = "SELECT status FROM profile WHERE uid=$u_id;";
    $result = mysqli_query($conn, $sql);
    $r = mysqli_fetch_assoc($result);
    $status = $r['status'];
    if ($status == "") $status = 'uploads/user.png';    
    if (isset($_SESSION['uid']) && $_GET['u'] == $_SESSION['username']) {
        echo '<ul class="profile-picture" id="profile-picture">
        <input type="file" name="profile_p" id="input" class="input-profile" accept="image/*"/>
        <label for="input"><li>Upload Photo</li></label>
        <li id="remove">Remove Profile Picture</li>
    </ul>';
    echo '<div class="profile-img-profile" onclick=""><img id="myprofile" style="height: 100%; width: 100%; object-fit: cover; z-index: 0;" src="'.$status.'"></div>';
    }
    else {
        echo '<div class="profile-img-profile" onclick=""><img id="myprofile" style="height: 100%; width: 100%; object-fit: cover; z-index: 0;" src="'.$status.'"></div>';
    }

    $sql = "SELECT * FROM profile, users WHERE profile.uid=$u_id AND users.username='".$_GET['u']."';";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        echo '<h2>'.$row['first_name'].' '.$row['last_name'].'</h2>
        <h3>@'.$row['username'].'</h3>
        <p>'.$row['bio'].'</p>'; 
    }
    else {
        echo '<h2></h2>
        <h3></h3>
        <p></p>';
    }

    if(isset($_SESSION['uid']) && $_GET['u'] == $_SESSION['username']) {
        echo '<a href="edit-profile.php"><button class="edit-button">Edit Profile</button></a>';
    }

?>
</div>