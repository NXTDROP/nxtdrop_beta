<?php
    session_start();
    include '../../dbh.php';
    require_once('../../../credentials.php');
    require_once('../../vendor/autoload.php');
    date_default_timezone_set("UTC");
    $date = date("Y-m-d H:i:s", time());
    \Stripe\Stripe::setApiKey($STRIPE_TEST_SECRET_KEY_CA);
    $item_ID = $_POST['item_ID'];
    $n_ID = $_SESSION['uid'];
    $s_ID = $_SESSION['stripe_acc'];
    $cus_ID = $_SESSION['cus_id'];

    if(!isset($_SESSION['uid'])) {
        echo "CONNECTION";
    }
    else {
        if($item_ID == "") {
            echo 'ID';
        }
        else {
            $query = "SELECT o.price, p.assetURL, p.model, o.sellerID FROM products p, offers o WHERE o.offerID = '$item_ID' AND o.productID = p.productID";
            $result = $conn->query($query);
            if(mysqli_num_rows($result) < 1) {
                echo 'ID';
            }
            else {
                $row = $result->fetch_assoc();
                $item_price = $row['price'];
                $item_pic = $row['assetURL'];
                $item_desc = $row['model'];
                $seller_ID = $row['sellerID'];
                $query = "SELECT * FROM thebag WHERE uid = '$n_ID'";
                $result = $conn->query($query);
                $row = mysqli_fetch_assoc($result);
                
                $query = "SELECT * FROM thebag WHERE uid = '$n_ID' AND stripe_id = '$s_ID'";
                    
                if(!$result = $conn->query($query)) {
                    echo 'ERROR';
                }
                else {
                    $row = $result->fetch_assoc();

                    try {
                        $account = \Stripe\Account::retrieve($s_ID);
                        $customer = \Stripe\Customer::retrieve($cus_ID);
                        
                        $street = $account['legal_entity']['address']['line1'];
                        $city = $account['legal_entity']['address']['city'];
                        $state = $account['legal_entity']['address']['state'];
                        $postalCode = $account['legal_entity']['address']['postal_code'];
                        $country = $_SESSION['country'];
                        if(isset($customer->default_source)) {
                            $card = $customer->sources->retrieve($row['out_token']);
                            $card_last4 = $card->last4;
                            $card_brand = $card->brand;
                        }
                        else {
                            $card_brand = "";
                            $card_last4 = "";
                        }

                        $getTrans = $conn->query("SELECT *  FROM transactions WHERE buyerID = '$n_ID'");
                        if($getTrans->num_rows > 0) {
                            $shipping = 13.65;
                        } else {
                            $shipping = 'FREE';
                        }
                        

                        $json = array();

                        $data = array(
                            'street' => $street,
                            'city' => $city,
                            'state' => $state,
                            'postalCode' => $postalCode,
                            'country' => $country,
                            'card_last4' => $card_last4,
                            'card_brand' => $card_brand,
                            'price' => $item_price,
                            'pic' => $item_pic,
                            'item' => $item_desc,
                            'seller_ID' => $seller_ID,
                            'shipping' => $shipping
                        );
                            
                        array_push($json, $data);

                        $jsonstring = json_encode($json);
                        echo $jsonstring;
                    } catch (\Stripe\Error\RateLimit $e) {
                        // Too many requests made to the API too quickly
                        die('DB');
                    } catch (\Stripe\Error\InvalidRequest $e) {
                        // Invalid parameters were supplied to Stripe's API
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

                        die('DB');
                    } catch (\Stripe\Error\ApiConnection $e) {
                        // Network communication with Stripe failed

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

                        die('DB');
                    }
                    catch (Exception $e) {
                        // Something else happened, completely unrelated to Stripe
                        die('DB');
                    }
                }
            }
        }
    }

?>