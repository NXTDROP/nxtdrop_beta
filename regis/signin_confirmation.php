<?php

    include '../dbh.php';
    date_default_timezone_set("UTC"); 
    $date = date("Y-m-d H:i:s", time());

    $query = "SELECT * FROM users";
    if($result = $conn->query($query)) {
        $num = mysqli_num_rows($result) + 100;

        echo '<h2 id="regis_title"><i class="far fa-check-circle" style="color: #fff"></i></h2>
        <div class="regis_content">
            <p style="color: #307024">Your acccount is set!</p>
            <strong>You are #'.$num.' on our waiting list.</strong>
            <p style="font-size: 12px; font-weight: 500;">Invite a friend and enter the priority list.</p>
            <p style="font-size: 12px; font-weight: 500;">We will send you an email with your invite code.</p>
            <p style="font-size: 11px; font-weight: 600;">It usually takes up to 2 weeks to be approved. Please be patient with us. THANK YOU!</p>
            <p style="font-size: 10px; font-weight: 600;">The NXTDROP Team.</p>
        </div>';
    }
    else {
        echo 'ERROR';
    }

?>