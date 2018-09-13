<?php

    session_start();

    if(!isset($_SESSION['uid'])) {
        echo 'CONNECT';
    }
    else {
        include '../../dbh.php';
        date_default_timezone_set("UTC");
        $confirmation_date = date("Y-m-d H:i:s", time());
        require_once('../../../credentials.php');
        \Stripe\Stripe::setApiKey($STRIPE_LIVE_SECRET_KEY);
        $resType = $conn->real_escape_string($_POST['resType']);
        $item_ID = $conn->real_escape_string($_POST['item_ID']);
        $buyer_ID = $conn->real_escape_string($_POST['buyer_ID']);
        $seller_ID = $_SESSION['uid'];

        $query = "SELECT * FROM transactions WHERE itemID = '$item_ID' AND sellerID = '$seller_ID' AND buyerID = '$buyer_ID' AND confirmationDate = '0000-00-00 00:00:00'";
        $result = $conn->query($query);
        if(mysqli_num_rows($result) < 1) {
            echo 'SOLD';
        }
        else {
            if($resType === "confirmation") {
                $row = $result->fetch_assoc();
                $transactionID = $row['transactionID'];
                $conn->autocommit(false);
                $updateTrans = $conn->query("UPDATE transactions SET confirmationDate = '$confirmation_date' WHERE itemID = '$item_ID' AND sellerID = '$seller_ID' AND buyerID = '$buyer_ID' AND confirmationDate = '0000-00-00 00:00:00';");
                $deleteNotif = $conn->query("DELETE FROM notifications WHERE post_id = '$item_ID' AND user_id = '$buyer_ID' AND target_id = '$seller_ID';");
                $getBuyerInfo = $conn->query("SELECT * FROM transactions, thebag WHERE transactions.transactionID = '$transactionID' AND thebag.uid = transactions.buyerID");

                if($updateTrans && $deleteNotif && $getBuyerInfo) {
                    try {
                        // Use Stripe's library to make requests...
                        $info = $getBuyerInfo->fetch_assoc();
                        $amount = $info['totalPrice'] * 100;
                        $buyerPaymentMethod = $info['out_token'];
                        $ID = "'".$transactionID."'";
                        $charge = \Stripe\Charge::create(array(
                            "amount" => $amount,
                            "currency" => "usd",
                            "source" => $buyerPaymentMethod,
                            "on_behalf_of" => $_SESSION['stripe_acc'],
                            "transfer_group" => $ID
                        ));
                        $chargeDate = date("Y-m-d H:i:s", time());
                        $chargeID = $charge->id;
                        $conn->query("INSERT INTO transactions SET chargeID = '$chargeID', chargeDate = '$chargeDate' WHERE transactionID = '$transactionID'");
                        $conn->commit();
                    } catch(\Stripe\Error\Card $e) {
                        // Since it's a decline, \Stripe\Error\Card will be caught
                        errorLog($e);
                        $conn->rollback();
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
                        $conn->rollback();
                        errorLog($e);
                        echo 'DB';
                    } catch (\Stripe\Error\ApiConnection $e) {
                        // Network communication with Stripe failed
                        $conn->rollback();
                        errorLog($e);
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
                        $conn->rollback();
                        echo 'DB';
                    }
                }
                else {
                    $conn->rollback();
                    echo 'DB';
                }
            }
            elseif($resType === "cancellation") {
                $conn->autocommit(false);
                $updateTrans = $conn->query("UPDATE transactions SET confirmationDate = '$confirmation_date', cancellationDate = '$confirmation_date', cancelledBy = '$seller_ID' WHERE itemID = '$item_ID' AND sellerID = '$seller_ID' AND buyerID = '$buyer_ID' AND confirmationDate = '0000-00-00 00:00:00';");
                $deleteNotif = $conn->query("DELETE FROM notifications WHERE post_id = '$item_ID' AND user_id = '$buyer_ID' AND target_id = '$seller_ID';");

                if($updateTrans && $deleteNotif) {
                    $conn->commit();
                }
                else {
                    $conn->rollback();
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