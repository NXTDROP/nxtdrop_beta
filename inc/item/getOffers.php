<?php

    session_start();
    require_once('../../dbh.php');
    $getOffers = $conn->prepare("SELECT o.offerID, o.productCondition, o.price, o.size FROM offers o, products p, transactions t WHERE p.model = ? AND o.productID = p.productID AND o.offerID = t.itemID AND t.status = 'waiting shipment';");
    $getOffers->bind_param("s", $model);

    if(!isset($_SESSION['uid'])) {
        die('CONNECTION');
    } else {
        if(!isset($_POST['model'])) {
            die('NOTFOUND');
        } else {
            $model = $_POST['model'];
            if($getOffers->execute()) {
                $getOffers->bind_result($offerID, $productCondition, $price, $size);
                while($getOffers->fetch()) {
                    echo '<div class="offer">
                            <div class="offer_description">
                                <p>Size: '.$size.'</p>
                                <p style="font-weight: bold;">$'.$price.'</p>
                                <p>Condition: '.$productCondition.'</p>
                            </div>
                            <button class="buy_now-btn" onclick="checkout('."'".$offerID."'".')">BUY NOW</button>
                            <button class="counter_offer-btn" onclick="counter('."'".$offerID."', "."'".$price."'".')">COUNTER-OFFER</button>
                        </div>';
                }
            } else {
                die('DB');
            }
        }
    }

?>