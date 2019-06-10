<?php

    include '../dbh.php';
    require_once('../../credentials.php');
    require_once('../vendor/autoload.php');
    include('../email/Email.php');
    \Stripe\Stripe::setApiKey($STRIPE_LIVE_SECRET_KEY);
    date_default_timezone_set("UTC"); 
    $date = date("Y-m-d H:i:s", time());

    function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    $name = $conn->real_escape_string($_POST['name']);
    $uName = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $pwd = md5(generateRandomString(25));
    $country = $conn->real_escape_string($_POST['country']);
    $inviteCode = $conn->real_escape_string($_POST['invite_code']);
    $error = false;
    $errorUsername = false;
    $iCodeError =  false;
    $conn->autocommit(false);

    if(isset($_POST['submit'])) {
        $sql = "SELECT email FROM users WHERE email = '$email' OR username = '$uName';";
        $result = $conn->query($sql);
        $check = mysqli_num_rows($result);
        if($check > 0) {
            echo "ACCOUNT";
            $error = true;
        }

        $getICode = $conn->query("SELECT * FROM users_code, invitationUsage WHERE users_code.invite_code = '$inviteCode' AND invitationUsage.codeID != users_code.codeID");
        $check = mysqli_num_rows($getICode);
        if($check > 0) {
            echo 'Invite code invalid or already used';
            $iCodeError = true;
        }

        // Remove all illegal characters from email
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo 'INVALID EMAIL';
            $error = true;
        }

        if($error == false && $iCodeError == false) {
            $createUser = $conn->query("INSERT INTO users (name, username, email, pwd, account_created, country, active_account) VALUES ('$name', '$uName', '$email', '$pwd', '$date', '$country', '1')");
            $getNewUser = $conn->query("SELECT * FROM users WHERE username = '$uName'");
            if ($getNewUser && $createUser) {

                $row = $getNewUser->fetch_assoc();
                $uid = $row['uid'];
                $createProfile = $conn->query("INSERT INTO profile (uid) VALUES ('$uid')");

                $code = mysqli_fetch_assoc($result);
                $codeID = $code['codeID'];
                if($check > 0) {$showInvite = $conn->query("INSERT INTO invitationUsage (usedBy, codeID, dateUsed) VALUES ('$uid', '$codeID', '$date')");}
                else {$showInvite = true;}
                $iCode = generateRandomString(6);
                $iCodeDate = date("Y-m-d H:i:s", time());
                $insertICode = $conn->query("INSERT INTO users_code (uid, invite_code, dateGenerated) VALUES ('$uid', '$iCode', '$iCodeDate')");

                if($createProfile && $insertICode && $showInvite) {
                    //try {
                        // Use Stripe's library to make requests...
                        /*$acct = \Stripe\Account::create(array(
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
                        ));*/

                        /*$cus_id = $cus->id;
                        $account_id = $acct->id;
                        $updateUsers = $conn->query("UPDATE users SET stripe_id = '$account_id', cus_id = '$cus_id' WHERE uid = '$uid';");
                        $thebag = $conn->query("INSERT INTO thebag (uid, stripe_id) VALUES ('$uid', '$account_id')");*/
                        $thebag = $conn->query("INSERT INTO thebag (uid) VALUES ('$uid')");
                        if($thebag) {
                            $conn->commit();
                            session_start();
                            $_SESSION['uid'] = $uid;
                            $_SESSION['name'] = $name;
                            $_SESSION['username'] = $uName;
                            $_SESSION['email'] = $email;
                            /*$_SESSION['stripe_acc'] = $account_id;
                            $_SESSION['cus_id'] = $cus_id;*/
                            $_SESSION['country'] = $country;

                            $createEmail = new Email($name, $email, 'hello@nxtdrop.com', 'Hi '.$uName.', welcome to NXTDROP', '');
                            if(!$createEmail->sendEmail('registration')) {
                                echo '';
                            }
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
                    /*} catch (\Stripe\Error\RateLimit $e) {
                        // Too many requests made to the API too quickly
                        errorLog($e);
                        $conn->rollback();
                        die('DB');
                    } catch (\Stripe\Error\InvalidRequest $e) {
                        // Invalid parameters were supplied to Stripe's API
                        errorLog($e);
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
                        $html = "<p>".$log."<br> Cannot connect to Stripe. Authentication Problem.</p>";
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
                        errorLog($e);
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

                        errorLog($e);
                        $conn->rollback();
                        die('DB');
                    }
                    catch (Exception $e) {
                        // Something else happened, completely unrelated to Stripe
                        $conn->rollback();
                        die('DB');
                    }*/
                }
                else {
                    $conn->rollback();
                    echo 'DB';
                }
            }
            else {
                $conn->rollback();
                echo 'DB';
            }
        }   
    }
    else {
        echo "There was an error!";
    }

    function errorLog($e) {
        $log_filename = $_SERVER['DOCUMENT_ROOT']."/log";

        $body = $e->getJsonBody();
        $err  = $body['error'];
        $log_msg = 'Status is:' . $e->getHttpStatus() . "\n" . 'Type is:' . $err['type'] . "\n" . 'Message is:' . $err['message'] . "\n" . 'Date:' . date("Y-m-d H:i:s", time());

        if (!file_exists($log_filename))
        {
            // create directory/folder uploads.
            mkdir($log_filename, 0777, true);
        }
        $log_file_data = $log_filename.'/log_' . date('d-M-Y') . '.log';
        file_put_contents($log_file_data, $log_msg . "\n", FILE_APPEND);
    }
?>