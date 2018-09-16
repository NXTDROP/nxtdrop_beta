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

    $email = $_POST['email'];

    $conn->autocommit(false);
    $getUsers = $conn->query("SELECT * FROM users WHERE email = '$email'");

    if($data = $getUsers->fetch_assoc) {
        $uid = $data['uid'];
        $country = $_POST['country'];

        $uName = $data['username'];
        $iCode = generateRandomString(6);
        $iCodeDate = date("Y-m-d H:i:s", time());
        $insertICode = $conn->query("INSERT INTO users_code (uid, invite_code, dateGenerated) VALUES ('$uid', '$iCode', '$iCodeDate'");

        if($insertICode) {
            $conn->commit();
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
                }
                else {
                    $conn->rollback();
                    $log = 'Username: '.$uName."\n".'StripeID: '.$account_id."\n".'CustomerID: '.$cus_id."\n";
                    error_log($log, 1, "stripeusa@nxtdrop.com", "subject: Important! UPDATE USERS ERROR");
                    echo 'DB';
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
        } else {
            $conn->rollback();
            echo 'DB';
        }
    } else {
        $conn->rollback();
        echo 'DB';
    }
?>