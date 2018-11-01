<?php
    session_start();
    include '../../dbh.php';
    require_once('../../../credentials.php');
    require_once('../../vendor/autoload.php');

    \Stripe\Stripe::setApiKey($STRIPE_LIVE_SECRET_KEY);
    $stripe_id = $_SESSION['stripe_acc'];
    $uid = $_SESSION['uid'];

    $balance = \Stripe\Balance::retrieve(array(
        'stripe_account' => $stripe_id
    ));

    $currency = strtolower($_POST['currency']);
    $transfer_type = $_POST['type'];
    $available_amount = $balance['available'][0]['amount'];

    if ($available_amount <= 0) {
        echo 'Your balance is $0.00. You cannot initiate a transfer.';
    }
    else  {
        if ($currency == 'cad' && $transfer_type == 1) {
            echo 'Instant Payout is only available in the US. Please try Standard Payout.';
        }
        else {
            if ($transfer_type == 0) {
                try {
                    // Use Stripe's library to make requests...
                    $payout = \Stripe\Payout::create(array(
                        "amount" => $available_amount, 
                        "currency" => $currency
                    ), array('stripe_account' => $stripe_id));
                } catch (\Stripe\Error\RateLimit $e) {
                    // Too many requests made to the API too quickly
                    $conn->rollback();
                    errorLog($e);
                    echo 'DB';
                } catch (\Stripe\Error\InvalidRequest $e) {
                    // Invalid parameters were supplied to Stripe's API
                    errorLog($e);
                    echo 'DB';
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

                    die('DB');
                } catch (\Stripe\Error\ApiConnection $e) {
                    // Network communication with Stripe failed
                    errorLog($e);
                    echo 'DB';
                } catch (\Stripe\Error\Base $e) {
                    // Display a very generic error to the user, and maybe send
                    // yourself an email
                    //SEND ALERT EMAIL
        
                    echo 'DB';
                } catch (Exception $e) {
                    // Something else happened, completely unrelated to Stripe
                    echo 'DB';
                }
            }
            else {
                try {
                    // Use Stripe's library to make requests...
                    $payout = \Stripe\Payout::create(array(
                        "amount" => $available_amount, 
                        "currency" => $currency,
                        'method' => 'instant'
                    ), array('stripe_account' => $stripe_id));
                } catch (\Stripe\Error\RateLimit $e) {
                    // Too many requests made to the API too quickly
                    $conn->rollback();
                    errorLog($e);
                    echo 'DB';
                } catch (\Stripe\Error\InvalidRequest $e) {
                    // Invalid parameters were supplied to Stripe's API
                    $conn->rollback();
                    errorLog($e);
                    echo 'DB';
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

                    die('DB');
                } catch (\Stripe\Error\ApiConnection $e) {
                    // Network communication with Stripe failed
                    errorLog($e);
                    echo 'DB';
                } catch (\Stripe\Error\Base $e) {
                    // Display a very generic error to the user, and maybe send
                    // yourself an email
                    //SEND ALERT EMAIL
                    echo 'DB';
                } catch (Exception $e) {
                    // Something else happened, completely unrelated to Stripe
                    echo 'DB';
                }
            }
        }
    }

    function errorLog($e) {
        $log_filename = $_SERVER['DOCUMENT_ROOT']."/log";

        $body = $e->getJsonBody();
        $err  = $body['error'];
        $log = 'Status is:' . $e->getHttpStatus() . "\n" . 'Type is:' . $err['type'] . "\n" . 'Code is:' . $err['code'] . "\n" . 'Message is:' . $err['message'] . "\n" . 'Date:' . date("Y-m-d H:i:s", time());

        if (!file_exists($log_filename))
        {
            // create directory/folder uploads.
            mkdir($log_filename, 0777, true);
        }
        $log_file_data = $log_filename.'/log_' . date('d-M-Y') . '.log';
        file_put_contents($log_file_data, $log . "\n", FILE_APPEND);
    }
?>