<?php
    session_start();
    include '../../dbh.php';
    require_once('../../../credentials.php');
    require_once('../../vendor/autoload.php');

    \Stripe\Stripe::setApiKey($STRIPE_TEST_SECRET_KEY);
    $stripe_id = $_SESSION['stripe_acc'];
    $uid = $_SESSION['uid'];

    $balance = \Stripe\Balance::retrieve(array(
        'stripe_account' => $stripe_id
    ));

    $currency = strtolower($_POST['currency']);
    $transfer_type = $_POST['type'];
    $available_amount = $balance['available'][0]['amount'];

    if ($available_amount >= 0) {
        echo 'Your balance is US$0.00. You cannot initiate a transfer.';
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
                    errorLog($e);
                    echo 'DB';
                } catch (\Stripe\Error\InvalidRequest $e) {
                    // Invalid parameters were supplied to Stripe's API
                    errorLog($e);
                    echo 'DB';
                } catch (\Stripe\Error\Authentication $e) {
                    // Authentication with Stripe's API failed
                    // (maybe you changed API keys recently)
                    errorLog($e);
                    echo 'DB';
                } catch (\Stripe\Error\ApiConnection $e) {
                    // Network communication with Stripe failed
                    errorLog($e);
                    echo 'DB';
                } catch (\Stripe\Error\Base $e) {
                    // Display a very generic error to the user, and maybe send
                    // yourself an email
                    $body = $e->getJsonBody();
                    $err  = $body['error'];
                    $log = 'Status is:' . $e->getHttpStatus() . "\n" . 'Type is:' . $err['type'] . "\n" . 'Code is:' . $err['code'] . "\n" . 'Param is:' . $err['param'] . "\n" . 'Message is:' . $err['message'] . "\n" . 'Date:' . date("Y-m-d H:i:s", time());
                    error_log($log, 1, "stripeusa@nxtdrop.com", "subject: Important! Error Stripe");
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
                    errorLog($e);
                    echo 'DB';
                } catch (\Stripe\Error\InvalidRequest $e) {
                    // Invalid parameters were supplied to Stripe's API
                    errorLog($e);
                    echo 'DB';
                } catch (\Stripe\Error\Authentication $e) {
                    // Authentication with Stripe's API failed
                    // (maybe you changed API keys recently)
                    errorLog($e);
                    echo 'DB';
                } catch (\Stripe\Error\ApiConnection $e) {
                    // Network communication with Stripe failed
                    errorLog($e);
                    echo 'DB';
                } catch (\Stripe\Error\Base $e) {
                    // Display a very generic error to the user, and maybe send
                    // yourself an email
                    $body = $e->getJsonBody();
                    $err  = $body['error'];
                    $log = 'Status is:' . $e->getHttpStatus() . "\n" . 'Type is:' . $err['type'] . "\n" . 'Code is:' . $err['code'] . "\n" . 'Param is:' . $err['param'] . "\n" . 'Message is:' . $err['message'] . "\n" . 'Date:' . date("Y-m-d H:i:s", time());
                    error_log($log, 1, "stripeusa@nxtdrop.com", "subject: Important! Error Stripe");
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