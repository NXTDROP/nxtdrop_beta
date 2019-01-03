<?php
    session_start();
    $db = '../../dbh.php';
    include $db;
    require_once('../../../credentials.php');
    require_once('../../vendor/autoload.php');
    require_once('../currencyConversion.php');
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
                $country = $_SESSION['country'];
                $query = "SELECT * FROM thebag WHERE uid = '$n_ID'";
                $result = $conn->query($query);
                $row = mysqli_fetch_assoc($result);
                
                $getTrans = $conn->query("SELECT * FROM transactions WHERE buyerID = '$n_ID'");
                if($getTrans->num_rows > 0) {
                    $shipping = 13.65;
                } else {
                    $shipping = 0;
                }

                if($country ==  'CA') {
                    $total = usdTocad($item_price + $shipping, $db, false);
                    $shipping = usdTocad($shipping, $db, false);
                    $item_price = usdTocad($item_price, $db, false);
                } else {
                    $total = $item_price + $shipping;
                    $shipping = $shipping;
                    $item_price = $item_price;
                }
                        

                $json = array();

                $data = array(
                    'country' => $country,
                    'price' => $item_price,
                    'pic' => $item_pic,
                    'item' => $item_desc,
                    'seller_ID' => $seller_ID,
                    'shipping' => $shipping,
                    'total' => $total
                );
                            
                array_push($json, $data);

                $jsonstring = json_encode($json);
                echo $jsonstring;
            }
        }
    }

?>