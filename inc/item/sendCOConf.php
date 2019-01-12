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
    $getBuyerInfo = $conn->prepare("SELECT users.stripe_id, address, users.cus_id FROM users, thebag WHERE users.uid = ? AND thebag.uid = users.uid;");
    $deleteNotif = $conn->prepare("DELETE FROM notifications WHERE post_id = ? AND user_id = ? AND target_id = ? AND notification_type = 'counter-offer'");
    $sendNotif = $conn->prepare("INSERT INTO notifications (post_id, user_id, target_id, notification_type, date) VALUES (?, ?, ?, ?, ?)");

    if(!isset($_SESSION['uid'])) {
        die('CONNECTION');
    } else {
        $confirmation = $_POST['confirmation'];
        $userID = $_POST['userID']; //userID of person that made CO
        $offerID = $_POST['offerID']; 

        if($confirmation == 'accepted') {
            //CREATE TRANSACTION
            /*$addTransaction = $conn->prepare("INSERT INTO transactions (itemID, sellerID, shippingAddress, buyerID, status, purchaseDate, confirmationDate, totalPrice) VALUES (?, ?, ?, ?, ?, ?, ?, ?);");

            $getTrans = $conn->query("SELECT *  FROM transactions WHERE buyerID = '$userID'");
            if($getTrans->num_rows > 0) {
                $shipping = 13.65;
            } else {
                $shipping = 00.00;
            }

            $price = $_POST['price'];
            $totalPrice = $price + $shipping;*/

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
    
                    /*$status = 'waiting shipment';
                    $purchaseDate = date("Y-m-d H:i:s", time());
                    $confirmationDate = $purchaseDate;*/
                    $seller_ID = $_SESSION['uid'];
                    /*$addTransaction->bind_param('iisisssd', $offerID, $seller_ID , $buyerAddress, $userID, $status, $purchaseDate, $confirmationDate, $totalPrice);
                    if($addTransaction->execute()) {
                        $addTransaction->close();*/
    
                        //GET TRANSACTIONID JUST CREATED ABOVE
                        /*$getTID = $conn->query("SELECT transactionID FROM transactions WHERE itemID = '$offerID' AND sellerID = '$seller_ID' AND purchaseDate = '$purchaseDate';");
                        $data = $getTID->fetch_assoc();
                        $transactionID = $data['transactionID'];
    
                        //CREATE SHIPMENT
                        $addShipping = $conn->query("INSERT INTO shipping (transactionID, cost) VALUES ('$transactionID', '$shipping');");*/
    
                        //DELETE notification
                        $deleteNotif->bind_param('iii', $offerID, $userID, $seller_ID);

                        //SEND notification
                        $type = 'counter-offer checkout';
                        $date = date("Y-m-d H:i:s", time());
                        $sendNotif->bind_param("iiiss", $offerID, $seller_ID, $userID, $type, $date);
    
                        //ADD CO to reviewedCO table
                        $date = date("Y-m-d H:i:s", time());
                        $status = 'accepted';
                        $addReviewCO->bind_param('iidsss', $offerID, $userID, $coPrice, $coDate, $status, $date);

                        //DELETE COUNTEROFFER
                        $deleteCO->bind_param('ii', $offerID, $userID);
    
                        if($deleteNotif->execute() && $addReviewCO->execute() && $deleteCO->execute() && $sendNotif->execute()) {
                            $deleteNotif->close();
                            $addReviewCO->close();
                            $deleteCO->close();
                            $sendNotif->close();
                            $conn->commit();

                            //EMAIL TO BUYER COUNTEROFFERCONFIRMATION
                            $email = new Email($buyerUsername, $buyerEmail, 'orders@nxtdrop.com', 'Congratulations, your counter-offer was accepted', '');
                            $email->setExt('offerID='.$offerID.'&userID='.$userID);
                            $email->sendEmail('counterOfferConf');

                            die('GOOD');
                        } else {
                            $conn->rollback();
                            die('DB');
                        }
                    /*} else {
                        $conn->rollback();
                        die('DB');
                    }*/
                } else {
                    $conn->rollback();
                    die('DB');
                }
            } else {
                $conn->rollback();
                die('DB');
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