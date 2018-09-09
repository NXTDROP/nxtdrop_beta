<?php
    session_start();
    include '../../dbh.php';
    require_once('../../credentials.php');
    require_once('../../vendor/autoload.php');
    date_default_timezone_set("UTC");
    $date = date("Y-m-d H:i:s", time());
    \Stripe\Stripe::setApiKey($STRIPE_TEST_SECRET_KEY);

    if(isset($_SESSION['uid'])) {
        $s_id = $_SESSION['stripe_acc'];
        $cus_id = $_SESSION['cus_id'];
        $n_id = $_SESSION['uid'];
        if($account = \Stripe\Account::retrieve($s_id)) {
            $json = array();

            $query = "SELECT * FROM thebag WHERE stripe_id = '$s_id' AND uid = '$n_id'";
            $result = $conn->query($query);
            if($row = mysqli_fetch_assoc($result)) {
                if($customer = \Stripe\Customer::retrieve($cus_id)) {
                    if($row['in_token'] != "") {
                        $bank_account = $account->external_accounts->retrieve($row['in_token']);
                        $b_last_4 = $bank_account->last4;
                        if($bank_account->object === "card") $b_brand = $bank_account->brand;
                        else $b_brand = 'Bank Account';
                    }
                    else {
                        $b_last_4 = '';
                        $b_brand = '';
                    }

                    if($row['out_token'] != "") {
                        $card = $customer->sources->retrieve($row['out_token']);
                        $c_last_4 = $card->last4;
                        $c_brand = $card->brand;
                    }
                    else {
                        $c_last_4 = '';
                        $c_brand = '';
                    }

                    if($_SESSION['country'] === 'CA') $social = $account['legal_entity']['personal_id_number_provided'];
                    else if ($_SESSION['country'] === 'US') $social = $account['legal_entity']['ssn_last_4'];

                    $data = array(
                        'entity' => $account['legal_entity']['type'],
                        'firstName' => $account['legal_entity']['first_name'],
                        'lastName' => $account['legal_entity']['last_name'],
                        'businessName' => $account['legal_entity']['business_name'],
                        'businessNumber' => $account['legal_entity']['business_tax_id_provided'],
                        'month' => $account['legal_entity']['dob']['month'],
                        'day' => $account['legal_entity']['dob']['day'],
                        'year' => $account['legal_entity']['dob']['year'],
                        'street' => $account['legal_entity']['address']['line1'],
                        'city' => $account['legal_entity']['address']['city'],
                        'state' => $account['legal_entity']['address']['state'],
                        'zip' => $account['legal_entity']['address']['postal_code'],
                        'social' => $social,
                        'payout_last4' => $b_last_4,
                        'payout_brand' => $b_brand,
                        'card_last4' => $c_last_4,
                        'card_brand' => $c_brand
                    );

                    array_push($json, $data);

                    $jsonstring = json_encode($json);
                    echo $jsonstring;
                }
                else {
                    echo 'ERROR';
                    die();
                }
            }
            else {
                echo 'ERROR';
                die();
            }
        }
        else {
            echo 'ERROR';
        }
    }
    else {
        echo 'ERROR';
    }
?>