<?php

/*session_start();
include 'dbh.php';
include('../credentials.php');
include('vendor/autoload.php');
include('email/Email.php');
date_default_timezone_set("UTC");
$purchaseDate = date("Y-m-d H:i:s", time());

$email = new Email('Yusuf', 'youssouphajr@gmail.com', 'orders@nxtdrop.com', 'Order Confirmed', '');
$email->setTransactionID('1');
$email->sendEmail('orderConfirmation_seller');


$email2 = new Email('momarcissex', 'momar@nxtdrop.com', 'orders@nxdrop.com', 'Order Confirmed', '');
$email2->setTransactionID('1');
$email2->sendEmail('orderConfirmation_seller');*/

include 'dbh.php';
        date_default_timezone_set("UTC");
        $confirmation_date = date("Y-m-d H:i:s", time());
        require_once('../credentials.php');
        require_once('vendor/autoload.php');
        require_once('email/Email.php');
        \Stripe\Stripe::setApiKey($STRIPE_LIVE_SECRET_KEY);

        try {
            // Use Stripe's library to make requests...
            $charge = \Stripe\Charge::create(array(
                "amount" => 100,
                "currency" => "usd",
                "customer" => 'cus_DeoL83Ms9cHQkN'
            ));
        } catch(\Stripe\Error\Card $e) {
            // Since it's a decline, \Stripe\Error\Card will be caught
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $log = 'TransactionID: '.$transactionID."\n".'Status is:' . $e->getHttpStatus() . "\n" . 'Type is:' . $err['type'] . "\n" . 'Code is:' . $err['code'] . "\n" . 'Param is:' . $err['param'] . "\n" . 'Message is:' . $err['message'] . "\n" . 'Date:' . date("Y-m-d H:i:s", time());
            rror_log($log, 1, "stripeusa@nxtdrop.com", "subject: Important! CARD DECLINED");
            echo 'Sorry, the payment method for this purchase was declined. This order will be cancelled. Thank you for choosing NXTDROP.';
            /*print('Status is:' . $e->getHttpStatus() . "\n");
            print('Type is:' . $err['type'] . "\n");
            print('Code is:' . $err['code'] . "\n");
            // param is '' in this case
            print('Param is:' . $err['param'] . "\n");
            print('Message is:' . $err['message'] . "\n");*/
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            echo 'DB';
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            echo 'DB';
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            echo 'DB';
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            echo 'DB';
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            echo 'DB';
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            echo 'DB';
        }
?>