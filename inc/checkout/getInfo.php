<?php

    session_start();
    include '../../dbh.php';
    require_once('../../../credentials.php');
    require_once('../../vendor/autoload.php');
    date_default_timezone_set("UTC");
    $date = date("Y-m-d H:i:s", time());
    \Stripe\Stripe::setApiKey($STRIPE_LIVE_SECRET_KEY);
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
            $query = "SELECT * FROM posts WHERE pid = '$item_ID'";
            $result = $conn->query($query);
            if(mysqli_num_rows($result) < 1) {
                echo 'ID';
            }
            else {
                $row = mysqli_fetch_assoc($result);
                $item_price = $row['product_price'];
                $item_pic = $row['pic'];
                $item_desc = $row['caption'];
                $seller_ID = $row['uid'];
                $query = "SELECT * FROM thebag WHERE uid = '$n_ID'";
                $result = $conn->query($query);
                $row = mysqli_fetch_assoc($result);
                
                $query = "SELECT * FROM thebag WHERE uid = '$n_ID' AND stripe_id = '$s_ID'";
                    
                if(!$result = $conn->query($query)) {
                    echo 'ERROR';
                }
                else {
                    $row = $result->fetch_assoc();
                    if(!$account = \Stripe\Account::retrieve($s_ID)) {
                        echo 'ERROR';
                    }
                    else {
                        if(!$customer = \Stripe\Customer::retrieve($cus_ID)) {
                            echo 'ERROR';
                        }
                        else {
                            $street = $account['legal_entity']['address']['line1'];
                            $city = $account['legal_entity']['address']['city'];
                            $state = $account['legal_entity']['address']['state'];
                            $postalCode = $account['legal_entity']['address']['postal_code'];
                            $country = $_SESSION['country'];
                            $card = $customer->sources->retrieve($row['out_token']);
                            $card_last4 = $card->last4;
                            $card_brand = $card->brand;

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
                                'seller_ID' => $seller_ID
                            );

                            array_push($json, $data);

                            $jsonstring = json_encode($json);
                            echo $jsonstring;
                        }
                    }
                }
        }
    }
}

?>