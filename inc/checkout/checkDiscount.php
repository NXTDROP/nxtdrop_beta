<?php
    session_start();
    include '../../dbh.php';
    require_once('../../../credentials.php');
    require_once('../../vendor/autoload.php');
    date_default_timezone_set("UTC");
    $date = date("Y-m-d H:i:s", time());
    \Stripe\Stripe::setApiKey($STRIPE_TEST_SECRET_KEY);
    $item_ID = $_POST['item_ID'];
    $code = $conn->real_escape_string($_POST['code']);
    $n_ID = $_SESSION['uid'];
    $s_ID = $_SESSION['stripe_acc'];
    $cus_ID = $_SESSION['cus_id'];

    if(!isset($_SESSION['uid'])) {
        echo "CONNECTION";
    }
    else {
        $checkDiscount = $conn->query("SELECT * FROM discountCode WHERE code = '$code';");
        if($checkDiscount->num_rows > 0) {
            $data = $checkDiscount->fetch_assoc();
            $codeID = $data['ID'];
            $discountUsed = $conn->query("SELECT ID, usedBy FROM discountUsed WHERE ID = '$codeID' AND usedBy = '$n_ID';");
            if($discountUsed->num_rows > 0) {
                die('INVALID');
            } else {
                $json = array();

                $data = array(
                    'ID' => $data['ID'],
                    'code' => $data['code'],
                    'type' => $data['type'],
                    'amount' => $data['amount']
                );

                array_push($json, $data);

                $jsonstring = json_encode($json);
                die($jsonstring);
            }
        } else {
            die('INVALID');
        }
    }  

?>