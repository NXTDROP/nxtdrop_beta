<?php

    session_start();
    require_once('../../dbh.php');
    include('../../../credentials.php');
    include('../../vendor/autoload.php');
    include('../../email/Email.php');
    \Stripe\Stripe::setApiKey($STRIPE_LIVE_SECRET_KEY);
    $conn->autocommit(false);
    date_default_timezone_set("UTC");
    $getCO = $conn->prepare("SELECT offer, date, username, email FROM counterOffer, users WHERE offerID = ? AND userID = ? AND userID = uid");
    $addReviewCO = $conn->prepare("INSERT INTO reviewedCO (offerID, userID, offer, date, status, reviewDate) VALUES (?, ?, ?, ?, ?, ?)");
    $deleteCO = $conn->prepare("DELETE FROM counterOffer WHERE offerID = ? AND userID = ?");
    $getBuyerInfo = $conn->prepare("SELECT users.stripe_id, address, out_token FROM users, thebag WHERE users.uid = ? AND thebag.uid = users.uid;");
    $deleteNotif = $conn->prepare("DELETE FROM notifications WHERE post_id = ? AND user_id = ? AND target_id = ? AND notification_type = 'counter-offer'");

    if(!isset($_SESSION['uid'])) {
        die('CONNECTION');
    } else {
        $confirmation = $_POST['confirmation'];
        $userID = $_POST['userID']; //userID of person that made CO
        $offerID = $_POST['offerID']; 

        if($confirmation == 'accepted') {
            //CREATE TRANSACTION
            $addTransaction = $conn->prepare("INSERT INTO transactions (itemID, sellerID, shippingAddress, buyerID, status, purchaseDate, confirmationDate, totalPrice) VALUES (?, ?, ?, ?, ?, ?, ?, ?);");

            $getTrans = $conn->query("SELECT *  FROM transactions WHERE buyerID = '$userID'");
            if($getTrans->num_rows > 0) {
                $shipping = 13.65;
            } else {
                $shipping = 00.00;
            }

            $price = $_POST['price'];
            $totalPrice = $price + $shipping;

            $getBuyerInfo->bind_param('i', $userID);
            $getCO->bind_param('ii', $offerID, $userID);
            if($getCO->execute()) {
                $getCO->bind_result($coPrice, $coDate, $buyerUsername, $buyerEmail);
                $getCO->fetch();
                $getCO->close();

                if($getBuyerInfo->execute()) {
                    $getBuyerInfo->bind_result($buyerStripeID, $buyerAddress, $buyerPaymentMethod);
                    $getBuyerInfo->fetch();
                    $getBuyerInfo->close();
    
                    $status = 'waiting shipment';
                    $purchaseDate = date("Y-m-d H:i:s", time());
                    $confirmationDate = $purchaseDate;
                    $seller_ID = $_SESSION['uid'];
                    $addTransaction->bind_param('iisisssd', $offerID, $seller_ID , $buyerAddress, $userID, $status, $purchaseDate, $confirmationDate, $totalPrice);
                    if($addTransaction->execute()) {
                        $addTransaction->close();
    
                        //GET TRANSACTIONID JUST CREATED ABOVE
                        $getTID = $conn->query("SELECT transactionID FROM transactions WHERE itemID = '$offerID' AND sellerID = '$seller_ID' AND purchaseDate = '$purchaseDate';");
                        $data = $getTID->fetch_assoc();
                        $transactionID = $data['transactionID'];
    
                        //CREATE SHIPMENT
                        $addShipping = $conn->query("INSERT INTO shipping (transactionID, cost) VALUES ('$transactionID', '$shipping');");
    
                        //DELETE notification
                        $deleteNotif->bind_param('iii', $offerID, $userID, $seller_ID);
    
                        //ADD CO to reviewedCO table
                        $date = date("Y-m-d H:i:s", time());
                        $status = 'accepted';
                        $addReviewCO->bind_param('iidsss', $offerID, $userID, $coPrice, $coDate, $status, $date);

                        //DELETE COUNTEROFFER
                        $deleteCO->bind_param('ii', $offerID, $userID);
    
                        if($addShipping && $deleteNotif->execute() && $addReviewCO->execute() && $deleteCO->execute()) {
                            $deleteNotif->close();
                            $addReviewCO->close();
                            $deleteCO->close();

                            try {
                                // Use Stripe's library to make requests...
                                $amount = $totalPrice * 100;
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

                                //EMAIL TO BUYER COUNTEROFFERCONFIRMATION
                                $email = new Email($buyerUsername, $buyerEmail, 'orders@nxtdrop.com', 'Congratulations, your counter-offer was accepted', '');
                                $email->setExt('offerID='.$offerID.'&userID='.$userID);
                                $email->sendEmail('counterOfferConf');

                                //EMAIL TO BUYER ORDERPLACED
                                $email = new Email($buyerUsername, $buyerEmail, 'stripeusa@nxdrop.com', 'Your NXTDROP Receipt [ORDER #'.$transactionID.']', '');
                                $email->setTransactionID($transactionID);
                                $email->sendEmail('orderPlaced');

                                //SEND EMAIL TO SELLER
                                $email = new Email($_SESSION['username'], $_SESSION['email'], 'stripeusa@nxdrop.com', 'Confirm order to get paid [ORDER #'.$transactionID.']', '');
                                $email->setTransactionID($transactionID);
                                $email->sendEmail('sellerConfirmation');

                                die('GOOD');
                            } catch(\Stripe\Error\Card $e) {
                                // Since it's a decline, \Stripe\Error\Card will be caught
                                $body = $e->getJsonBody();
                                $err  = $body['error'];
                                $log = 'Status is:' . $e->getHttpStatus() . "\n" . 'Type is:' . $err['type'] . "\n" . 'Code is:' . $err['code'] . "\n" . 'Message is:' . $err['message'] . "\n" . 'Date:' . date("Y-m-d H:i:s", time());
    
                                //send prepare email with error message
                                $email = new \SendGrid\Mail\Mail(); 
                                $email->setFrom("admin@nxtdrop.com", "NXTDROP");
                                $email->setSubject("URGENT! Card Decline!");
                                $email->addTo('stripeusa@nxtdrop.com', 'NXTDROP');
                                $html = "<p>".$log."</p>";
                                $email->addContent("text/html", $html);
                                $sendgrid = new \SendGrid($SD_TEST_API_KEY);
    
                                //send email
                                try {
                                    $response = $sendgrid->send($email);
                                    $conn->rollback();
                                    die('CARD');
                                } catch (Exception $e) {
                                    $conn->rollback();
                                    die('CARD');
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
                                $email->setSubject("URGENT! Error Send Counter-Offer COnfirmation.");
                                $email->addTo('momar@nxtdrop.com', 'MOMAR CISSE');
                                $html = "<p>".$log."<br> Cannot connect to Stripe. Authentication Problem.</p>";
                                $email->addContent("text/html", $html);
                                $sendgrid = new \SendGrid($SD_TEST_API_KEY);
                                try {
                                    $response = $sendgrid->send($email);
                                    $conn->rollback();
                                    die('DB');
                                } catch (Exception $e) {
                                    $conn->rollback();
                                    die('DB');
                                }
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
                            } catch (Exception $e) {
                                // Something else happened, completely unrelated to Stripe
                                $conn->rollback();
                                die('DB');
                            }
                        } else {
                            $conn->rollback();
                            die('DB');
                        }
                    } else {
                        $conn->rollback();
                        die('DB');
                    }
                } else {
                    $conn->rollback();
                    die('DB');
                }
            }

        } elseif($confirmation == 'declined') {
            $getCO->bind_param('ii', $offerID, $userID);
            if($getCO->execute()) {
                $getCO->bind_result($coPrice, $coDate, $buyerUsername, $buyerEmail);
                $getCO->fetch();
                $getCO->close();

                $date = date("Y-m-d H:i:s", time());
                $status = 'declined';
                $addReviewCO->bind_param('iidsss', $offerID, $userID, $coPrice, $coDate, $status, $date);
                if($addReviewCO->execute()) {
                    $addReviewCO->close();

                    $deleteCO->bind_param('ii', $offerID, $userID);
                    if($deleteCO->execute()) {
                        $deleteCO->close();

                        $seller_ID = $_SESSION['uid'];
                        $deleteNotif->bind_param('iii', $offerID, $userID, $seller_ID);
                        if($deleteNotif->execute()) {
                            $conn->commit();
                            //EMAIL TO BUYER
                            $email = new Email($buyerUsername, $buyerEmail, 'orders@nxtdrop.com', 'Sorry, your counter-offer was rejected', '');
                            $email->setExt('offerID='.$offerID.'&userID='.$userID);
                            $email->sendEmail('counterOfferConf');

                            die('GOOD');
                        } else {
                            $conn->commit();
                            die('GOOD');
                        }
                    } else {
                        $conn->rollback();
                        die('DB');
                    }
                } else {
                    $conn->rollback();
                    die('DB');
                }
            } else {
                $conn->rollback();
                die('DB');
            }
        } else {
            die('DB');
        }
    }

?>