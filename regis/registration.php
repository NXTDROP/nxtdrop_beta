<?php

    include '../dbh.php';
    require_once('../../credentials.php');
    require_once('../vendor/autoload.php');
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

    $name = $conn->real_escape_string($_POST['name']);
    $uName = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $pwd = $conn->real_escape_string($_POST['pwd']);
    $country = $conn->real_escape_string($_POST['country']);
    $iCodeError = false;
    $errorEmail = false;
    $errorUsername = false;

    if(isset($_POST['submit'])) {
        if (empty($uName) || empty($email) || empty($pwd)) {
            echo "Fill in all the fields!";
            $errorEmpty = true;
        }
        
        $sql = "SELECT email FROM users WHERE email = '$email';";
        $result = $conn->query($sql);
        $check = mysqli_num_rows($result);
        if($check > 0) {
            echo "E-mail already used!";
            $errorEmail = true;
        }

        $sql = "SELECT username FROM users WHERE username = '$uName';";
        $result = $conn->query($sql);
        $check = mysqli_num_rows($result);
        if ($check > 0) {
            echo "Username already used!";
            $errorUsername = true;
        }

        $result = $conn->query("SELECT * FROM users_code, invitationUsage WHERE users_code.invite_code = '$inviteCode' AND invitationUsage.codeID != users_code.codeID");
        $check = mysqli_num_rows($result);
        if($check > 0) {
            echo 'Invite code invalid or already used';
            $iCodeError = true;
        }

        // Remove all illegal characters from email
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo 'INVALID EMAIL';
            $errorEmail = true;
        }

        if($iCodeError == false && $errorEmail == false && $errorUsername == false) {
            $pwd = md5($pwd);
            $conn->autocommit(false);
            $createUser = $conn->query("INSERT INTO users (name, username, email, pwd, account_created, country, active_account) VALUES ('$name', '$uName', '$email', '$pwd', '$date', '$country', '1')");
            $getNewUser = $conn->query("SELECT * FROM users WHERE username = '$uName'");
            if ($createUser && $getNewUser) {

                $row = $getNewUser->fetch_assoc();
                $uid = $row['uid'];
                $createProfile = $conn->query("INSERT INTO profile (uid) VALUES ('$uid')");

                $code = mysqli_fetch_assoc($result);
                $codeID = $code['codeID'];
                if($check > 0) {$showInvite = $conn->query("INSERT INTO invitationUsage (usedBy, codeID, dateUsed) VALUES ('$uid', '$codeID', '$date')");}
                else {$showInvite = true;}

                $iCode = generateRandomString(6);
                $iCodeDate = date("Y-m-d H:i:s", time());
                $insertICode = $conn->query("INSERT INTO users_code (uid, invite_code, dateGenerated) VALUES ('$uid', '$iCode', '$iCodeDate'");
                
                if($createProfile && $insertICode && ($showInvite || $showInvite === true)) {
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
                        if($updateUsers) {
                            $conn->commit();
                            session_start();
                            $_SESSION['uid'] = $uid;
                            $_SESSION['name'] = $name;
                            $_SESSION['username'] = $uName;
                            $_SESSION['email'] = $email;
                            $_SESSION['stripe_acc'] = $account_id;
                            $_SESSION['cus_id'] = $cus_id;
                            $_SESSION['country'] = $country;
                        }
                        else {
                            $conn->rollback();
                            $log = 'Username: '.$uName."\n".'StripeID: '.$account_id."\n".'CustomerID: '.$cus_id."\n";
                            error_log($log, 1, "stripeusa@nxtdrop.com", "subject: Important! UPDATE USERS ERROR");
                        }
                    } catch (\Stripe\Error\RateLimit $e) {
                        // Too many requests made to the API too quickly
                        errorLog($e);
                        $conn->rollback();
                        echo 'DB';
                    } catch (\Stripe\Error\InvalidRequest $e) {
                        // Invalid parameters were supplied to Stripe's API
                        errorLog($e);
                        $conn->rollback();
                        echo 'DB';
                    } catch (\Stripe\Error\Authentication $e) {
                        // Authentication with Stripe's API failed
                        // (maybe you changed API keys recently)
                        errorLog($e);
                        $conn->rollback();
                        echo 'DB';
                    } catch (\Stripe\Error\ApiConnection $e) {
                        // Network communication with Stripe failed
                        errorLog($e);
                        $conn->rollback();
                        echo 'DB';
                    } catch (\Stripe\Error\Base $e) {
                        // Display a very generic error to the user, and maybe send
                        // yourself an email
                        $body = $e->getJsonBody();
                        $err  = $body['error'];
                        $log = 'Status is:' . $e->getHttpStatus() . "\n" . 'Type is:' . $err['type'] . "\n" . 'Code is:' . $err['code'] . "\n" . 'Param is:' . $err['param'] . "\n" . 'Message is:' . $err['message'] . "\n" . 'Date:' . date("Y-m-d H:i:s", time());
                        error_log($log, 1, "stripeusa@nxtdrop.com", "subject: Important! Error Stripe");
                        $conn->rollback();
                        echo 'DB';
                    } catch (Exception $e) {
                        // Something else happened, completely unrelated to Stripe
                        echo 'DB';
                    }

                    $email = new \SendGrid\Mail\Mail(); 
                    $email->setFrom("admin@nxtdrop.com", "NXTDROP");
                    $email->setSubject("Welcome to NXTDROP.");
                    $email->addTo($row['email'], $name);
                    $htmlcontent = '<title>Welcome to NXTDROP.</title><head><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|PT+Sans|Roboto+Mono|Roboto+Slab" rel="stylesheet"> <style>* {-webkit-transition: background-color 0.25s ease-out;-moz-transition:background-color 0.25s ease-out;-o-transition: background-color 0.25s ease-out;transition: background-color 0.25s ease-out;}a {text-decoration: none;}body {margin: 0;padding: 0;font-family: "Segoe UI","Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";min-height: 98.77%;background-color: #f4f4f4;color: #fff;}.email_head {width: 100%;padding: 10px 0;}.email_head a img {width: 15%;display: block;margin: auto;}.email_body {width: 75%;background: #fff;margin: 15px auto;border-radius: 4px;padding: 15px;color: #000;text-align: center;}.email_body h1 {font-size: 18px;color: #aa0000;font-weight: 800;}.email_body p {font-size: 13px;color: #000;font-weight: 400;}.email_footer {width: 75%;background: #fff;color: #000;margin: 0 auto;border-radius: 4px;padding: 15px;font-size: 12px;}.email_footer a {color: #0e7bce;}.email_footer p {font-weight: 400;}.email_footer a {font-weight: 400;}hr {width: 50%;color: #fff;}#invite_code {text-align: center;background: #0e7bce;width: 20%;color: #fff;border-radius: 4px;font-size: 18px;margin: 0 auto;padding: 5px 10px;-webkit-transition: background-color 0.25s ease-out-moz-transition: background-color 0.25s ease-out;-o-transition: background-color 0.25s ease-out;transition: background-color 0.25s ease-out;}#invite_code:hover {cursor: pointer;background: #0591fc;}#greetings {background: #aa0000;color: #fff;padding: 15px;text-align: center;}.ticket {background: #aa0000; padding: 3px; text-align: center; color: #fff; font-size: 12px;border-radius: 6px;}#login {background: #aa0000;color: #fff;text-align: center;width: 25%;margin: 0 37.5%;padding: 5px;border-radius: 24px;border: 1px solid #aa0000;}#login:hover {background: #fff;color: #aa0000;border: 1px solid #aa0000;}.ticket:hover {background: #d11f1f;cursor: pointer;}ul {list-style: none;text-align: center;padding: 0;margin: 0;}ul li {display: inline-block;}ul li a p {color: #aa0000;}ul li a p:hover {cursor: pointer;text-decoration: underline}.image {width: 35px;}#copy {font-size: 10px;text-align: center;background: #aa0000;color: #fff;}</style></head><body><div class="email_head"><a href="https://nxtdrop.com"><img src="https://nxtdrop.com/img/nxtdroplogo.png" alt="NXTDROP, INC." title="NXTDROP, Inc."></a></div><hr><div class="email_body"><h1>Hi <span class="ticket">'.$name.'</span>,</h1><p>Welcome to NXTDROP, your trusted marketplace. Thank you for joining our community. Buying, selling and trading sneakers and grails is made faster and secure with NXTDROP. We make sure that all listed items are 100% authentic. You can enter an exclusive raffle every month to win a pair of sneaker. Consignment fees are lifted every two sales until <span class="ticket">Jan. 2019.</span></p><p style="font-size: 14px; font-weight: 700;">Login to enter this month raffle!</p><a href="https://nxtdrop.com/login_signup"><p id="login" title="Login To Your Account">LOGIN</p></a><br></div><div class="email_footer"><p style="color: #777777">Disclaimer: This e-mail message is an automated notification. Please do not reply to this message.</p><p>Thanks for creating your account. We hope to see you soon make your first purchase or sale with us.</p><a href="https://nxtdrop.com">NXTDROP.COM</a><p>Buy, Sell & Trade Fashion</p><ul><li><p><a href="https://www.instagram.com/nxtdrop/"><img class="image" src="https://nxtdrop.com/img/instagram.png" title="Instagram"/></a></p></li><li><p><a href="https://www.twitter.com/nxtdrop/"><img class="image" src="https://nxtdrop.com/img/twitter.png" title="Twitter"/></a></p></li></ul><ul><li><a href="https://nxtdrop.com/"><p title="Unsusbcribe"> Unsuscribe </p></a></li><li><a href="https://nxtdrop.com/terms"><p title="Terms of Use"> Terms of Use </p></a></li><li><a href="https://nxtdrop.com/privacy"><p title="Privacy Policy"> Privacy Policy </p></a></li><li><a href="https://nxtdrop.com/login_signup"><p title="Login"> Login </p></a></li></ul><p id="copy">&copy; 2018 NXTDROP, INC. All rights reserved.</p></div></body>';
                    $email->addContent("text/html", "$htmlcontent");
                    $sendgrid = new \SendGrid($SENDGRID_API_KEY);
                    try {
                        $response = $sendgrid->send($email);
                    } catch (Exception $e) {
                        echo 'EMAIL';
                    }
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
        $log_msg = 'Status is:' . $e->getHttpStatus() . "\n" . 'Type is:' . $err['type'] . "\n" . 'Code is:' . $err['code'] . "\n" . 'Param is:' . $err['param'] . "\n" . 'Message is:' . $err['message'] . "\n" . 'Date:' . date("Y-m-d H:i:s", time());

        if (!file_exists($log_filename))
        {
            // create directory/folder uploads.
            mkdir($log_filename, 0777, true);
        }
        $log_file_data = $log_filename.'/log_' . date('d-M-Y') . '.log';
        file_put_contents($log_file_data, $log_msg . "\n", FILE_APPEND);
    }
?>