<?php

    require_once('../../../credentials.php');
    require_once('../../dbh.php');
    require_once('../../vendor/autoload.php');
    require_once('../../email/Email.php');

    if (isset($_POST['request'])) {
        $request = $_POST['request'];
        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom("admin@nxtdrop.com", "Request Department");
        $email->setSubject("Product Request");
        $email->addTo('support@nxtdrop.com', 'NXTDROP');
        $html = "<p>Requested Shoes: ".$request."</p>";
        $email->addContent("text/html", $html);
        $sendgrid = new \SendGrid($SD_TEST_API_KEY);
        try {
            $sendgrid->send($email);
            die('GOOD');
        } catch (Exception $e) {
            die('DB');
        } 
    } else {
        die('ERROR');
    }

?>