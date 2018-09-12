<?php

    session_start();

    if(!isset($_SESSION['uid'])) {
        echo 'CONNECT';
    }
    else {
        include '../../dbh.php';
        date_default_timezone_set("UTC");
        require_once('../../../credentials.php');
        \Stripe\Stripe::setApiKey($STRIPE_TEST_SECRET_KEY);
        $comment = $conn->real_escape_string($_POST['comment']);
        $item_ID = $conn->real_escape_string($_POST['item_ID']);
        $buyer_ID = $conn->real_escape_string($_POST['buyer_ID']);
        $condition = $conn->real_escape_string($_POST['itemCondition']);
        $MM_ID = $_SESSION['uid'];

        $query = "SELECT * FROM transactions WHERE itemID = '$item_ID' AND middlemanID = '$MM_ID' AND buyerID = '$buyer_ID' AND verificationDate = '0000-00-00 00:00:00'";
        $result = $conn->query($query);
        if(mysqli_num_rows($result) < 1) {
            echo 'VERIFIED';
        }
        else {
            $row = $result->fetch_assoc();
            $transactionID = $row['transactionID'];

            if($condition === "OG") {
                $verificationDate = date("Y-m-d H:i:s", time());
                $conn->autocommit(false);
                $updateTrans = $conn->query("UPDATE transactions SET verificationDate = '$verificationDate', status = 'verified' WHERE itemID = '$item_ID' AND middlemanID = '$MM_ID' AND buyerID = '$buyer_ID'");
                $deleteNotif = $conn->query("DELETE FROM notifications WHERE post_id = '$item_ID' AND user_id = '0' AND target_id = '0' AND middleman_id = '$MM_ID';");
                $getTransactionInfo = $conn->query("SELECT * FROM transactions, thebag WHERE transactions.transactionID = '$transactionID' AND transactions.sellerID = thebag.uid");

                if($updateTrans && $deleteNotif) {
                    $info = $getTransactionInfo->fetch_assoc();
                    $stripeID = $info['stripe_id'];
                    $total = $info['totalPrice'] * 100;
                    $sellerPay = $total - ($total * 0.125);
                    $MMPay = ($total * 0.03) + 1365;
                    $ID = "'".$transactionID."'";

                    try {
                        // Use Stripe's library to make requests...

                        // Create a Transfer to the Seller:
                        $transfer = \Stripe\Transfer::create(array(
                            "amount" => $sellerPay,
                            "currency" => "usd",
                            "destination" => $stripeID,
                            "transfer_group" => $ID,
                        ));
                        
                        // Create a second Transfer to the MiddleMan:
                        $transfer = \Stripe\Transfer::create(array(
                            "amount" => $MMPay,
                            "currency" => "usd",
                            "destination" => $_SESSION['stripe_acc'],
                            "transfer_group" => $ID,
                        ));
                        $conn->commit();
                    } catch (\Stripe\Error\RateLimit $e) {
                        // Too many requests made to the API too quickly
                        errorLog($e);
                        $conn->rollback();
                        echo 'DB';
                    } catch (\Stripe\Error\InvalidRequest $e) {
                        // Invalid parameters were supplied to Stripe's API
                        $conn->rollback();
                        errorLog($e);
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
                        $conn->rollback();
                        echo 'DB';
                    }
                }
                else {
                    $conn->rollback();
                    echo 'DB';
                }
            }
            elseif($condition === "FAKE") {
                $verificationDate = date("Y-m-d H:i:s", time());
                $conn->autocommit(false);
                $updateTrans = $conn->query("UPDATE transactions SET verificationDate = '$verificationDate', cancellationDate = '$verificationDate', cancelledBy = '$MM_ID' WHERE itemID = '$item_ID' AND buyerID = '$buyer_ID' AND verificationDate = '0000-00-00 00:00:00';");
                $deleteNotif = $conn->query("DELETE FROM notifications WHERE post_id = '$item_ID' AND user_id = '0' AND target_id = '0' AND middleman_id = '$MM_ID';");
                $getTransactionInfo = $conn->query("SELECT * FROM transactions WHERE transactions.transactionID = '$transactionID'");

                if($updateTrans && $deleteNotif && $getTransactionInfo) {
                    $info = $getTransactionInfo->fetch_assoc();
                    $chargeID = $info['chargeID'];
                    try {
                        // Use Stripe's library to make requests...
                        $refund = \Stripe\Refund::create(array(
                            "charge" => $chargeID,
                        ));
                        $conn->commit();
                    } catch (\Stripe\Error\RateLimit $e) {
                        // Too many requests made to the API too quickly
                        errorLog($e);
                        $conn->rollback();
                        echo 'DB';
                    } catch (\Stripe\Error\InvalidRequest $e) {
                        // Invalid parameters were supplied to Stripe's API
                        $conn->rollback();
                        errorLog($e);
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