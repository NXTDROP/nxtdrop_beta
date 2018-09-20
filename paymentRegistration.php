<?php

    include 'dbh.php';
    require_once('../credentials.php');
    require_once('vendor/autoload.php');
    \Stripe\Stripe::setApiKey($STRIPE_LIVE_SECRET_KEY);
    date_default_timezone_set("UTC"); 
    $date = date("Y-m-d H:i:s", time());

    function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ/*-+$!:;,.';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    $email = $_POST['email'];

    $conn->autocommit(false);
    $getUsers = $conn->query("SELECT * FROM users WHERE email = '$email'");

    if($data = $getUsers->fetch_assoc()) {
        $uid = $data['uid'];
        
        if($data['country'] === '') {
            $country = $_POST['country'];
        } else {
            $country = $data['country'];
            if($data['stripe_id'] != '' && $data['active_account'] === '1') {
                die('DONE');
            }
        }

        $uName = $data['username'];
        $iCode = generateRandomString(6);
        $iCodeDate = date("Y-m-d H:i:s", time());
        $insertICode = $conn->query("INSERT INTO users_code (uid, invite_code, dateGenerated) VALUES ('$uid', '$iCode', '$iCodeDate')");

        if($insertICode) {
            if($data['stripe_id'] === '') {
                try {
                    // Use Stripe's library to make requests...
                    $acct = \Stripe\Account::create(array(
                        "country" => "$country",
                        "type" => "custom", 
                        "email" => "$email",
                        "tos_acceptance" => array(
                            "date" => time(),
                            "ip" => $_SERVER['REMOTE_ADDR']
                        )
                    ));
    
                    $cus = \Stripe\Customer::create(array(
                        "email" => "$email",
                    ));
    
                    $cus_id = $cus->id;
                    $account_id = $acct->id;
                    $updateUsers = $conn->query("UPDATE users SET stripe_id = '$account_id', cus_id = '$cus_id' WHERE uid = '$uid';");
                    $activateAccount = $conn->query("UPDATE users SET active_account='1' WHERE email='$email';");
                    if($updateUsers && $activateAccount) {
                        $conn->commit();
                    }
                    else {
                        $email = new \SendGrid\Mail\Mail(); 
                        $email->setFrom("admin@nxtdrop.com", "NXTDROP ERROR");
                        $email->setSubject("URGENT! Error Registration Stripe.");
                        $email->addTo('momar@nxtdrop.com', 'MOMAR CISSE');
                        $html = "<p>Username: " . $uName . ", stripe_id: " . $account_id . ", customer_id: " . $cus_id . ", Date: " . date("Y-m-d H:i:s", time()) . ", Message: Couldn't update Stripe accounts IDs to Database. Please do so manually. Thank You!</p>";
                        $email->addContent("text/html", $html);
                        $sendgrid = new \SendGrid($SD_TEST_API_KEY);
                        try {
                            $sendgrid->send($email);
                        } catch (Exception $e) {
                            $cu = \Stripe\Customer::retrieve($cus_id);
                            $ac = \Stripe\Account::retrieve($account_id);
                            $cu->delete();
                            $ac->delete();
                            $conn->rollback();
                            die('DB');
                        }   
                        $conn->commit();
                    }
                } catch (\Stripe\Error\RateLimit $e) {
                    // Too many requests made to the API too quickly
                    $conn->rollback();
                    die('DB');
                } catch (\Stripe\Error\InvalidRequest $e) {
                    // Invalid parameters were supplied to Stripe's API
                    $conn->rollback();
                    die('DB');
                } catch (\Stripe\Error\Authentication $e) {
                    // Authentication with Stripe's API failed
                    // (maybe you changed API keys recently)
                    $body = $e->getJsonBody();
                    $err  = $body['error'];
                    $log = 'Status is:' . $e->getHttpStatus() . "\n" . 'Type is:' . $err['type'] . "\n" . 'Code is:' . $err['code'] . "\n" . 'Message is:' . $err['message'] . "\n" . 'Date:' . date("Y-m-d H:i:s", time());
                    $email = new \SendGrid\Mail\Mail(); 
                    $email->setFrom("admin@nxtdrop.com", "NXTDROP");
                    $email->setSubject("URGENT! Error Update User Regis.");
                    $email->addTo('momar@nxtdrop.com', 'MOMAR CISSE');
                    $html = "<p>Cannot connect to Stripe. Authentication Problem. paymentRegistration.php</p>";
                    $email->addContent("text/html", $html);
                    $sendgrid = new \SendGrid($SD_TEST_API_KEY);
                    try {
                        $response = $sendgrid->send($email);
                    } catch (Exception $e) {
                        die('DB');
                    }
                    $conn->rollback();
                    die('DB');
                } catch (\Stripe\Error\ApiConnection $e) {
                    // Network communication with Stripe failed
                    $conn->rollback();
                    die('DB');
                } catch (\Stripe\Error\Base $e) {
                    // Display a very generic error to the user, and maybe send
                    // yourself an email
    
                    //get error
                    $body = $e->getJsonBody();
                    $err  = $body['error'];
                    $log = 'Status is:' . $e->getHttpStatus() . "\n" . 'Type is:' . $err['type'] . "\n" . 'Code is:' . $err['code'] . "\n" . 'Message is:' . $err['message'] . "\n" . 'Date:' . date("Y-m-d H:i:s", time());
    
                    //send prepare email with error message
                    $email = new \SendGrid\Mail\Mail(); 
                    $email->setFrom("admin@nxtdrop.com", "NXTDROP");
                    $email->setSubject("URGENT! Error Update User Regis.");
                    $email->addTo('momar@nxtdrop.com', 'MOMAR CISSE');
                    $html = "<p>".$log."</p>";
                    $email->addContent("text/html", $html);
                    $sendgrid = new \SendGrid($SD_TEST_API_KEY);
    
                    //send email
                    try {
                        $response = $sendgrid->send($email);
                    } catch (Exception $e) {
                        die('DB');
                    }
    
                    $conn->rollback();
                    die('DB');
                }
                catch (Exception $e) {
                    // Something else happened, completely unrelated to Stripe
                    $conn->rollback();
                    die('DB');
                }
            } else {
                $activateAccount = $conn->query("UPDATE users SET active_account='1' WHERE email='$email';");

                if($activateAccount) {
                    $conn->commit();
                } else {
                    $conn->rollback();
                    die('DB');
                }
            }
        } else {
            $conn->rollback();
            die('DB');
        }
    } else {
        $conn->rollback();
        die('DB');
    }
?>