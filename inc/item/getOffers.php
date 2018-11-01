<?php

    session_start();
    require_once('../../dbh.php');
    $db = '../../dbh.php';
    require_once('../currencyConversion.php');
    $getOffers = $conn->prepare("SELECT A.offerID, A.productCondition, A.price, A.size FROM (SELECT o.offerID, o.productCondition, o.price, o.size FROM offers o, products p WHERE p.productID = ? AND o.productID = p.productID) A LEFT JOIN (SELECT o.offerID, o.productCondition, o.price, o.size FROM offers o, products p, transactions t WHERE p.productID = ? AND o.productID = p.productID AND o.offerID = t.itemID AND t.status != 'cancelled') B ON A.offerID = B.offerID WHERE B.offerID IS NULL ORDER BY A.size;");
    $getOffers->bind_param("ss", $model, $model);

    /*if(!isset($_SESSION['uid'])) {
        die('CONNECTION');
    } else { SELECT A.offerID, A.productCondition, A.price, A.size FROM (SELECT o.offerID, o.productCondition, o.price, o.size FROM offers o, products p WHERE p.productID = 1000001 AND o.productID = p.productID) A LEFT JOIN (SELECT o.offerID, o.productCondition, o.price, o.size FROM offers o, products p, transactions t WHERE p.productID = 1000001 AND o.productID = p.productID AND o.offerID = t.itemID AND t.status != 'cancelled') B ON A.offerID = B.offerID WHERE B.offerID IS NULL ORDER BY A.size
        
    }*/

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
                            <p style="font-weight: bold;">'.usdTocad($price, $db, true).'</p>
                            <p>Condition: '.$productCondition.'</p>
                        </div>
                        <button class="buy_now-btn" onclick="checkout('."'".$offerID."'".')">BUY NOW</button>';

                if(isset($_SESSION['uid'])) {
                    echo '<button class="counter_offer-btn" onclick="counter('."'".$offerID."', "."'".$price."'".')">COUNTER-OFFER</button>';
                } else {
                    echo '<button class="counter_offer-btn" onclick="checkout('."'".$offerID."'".')">COUNTER-OFFER</button>';
                }
                echo '</div>';
            }
        } else {
            die('DB');
        }
    }

?>