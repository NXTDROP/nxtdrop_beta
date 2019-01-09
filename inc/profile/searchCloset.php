<?php
    session_start();
    $db = '../../dbh.php';
    require_once($db);
    require_once('../currencyConversion.php');

    $q = $_POST['q'];
    $uid = $_SESSION['uid'];

    $getCloset = $conn->prepare("SELECT p.productID, p.model, p.assetURL, MIN(o.price), COUNT(o.offerID) FROM offers o, products p WHERE o.sellerID = ? AND o.productID = p.productID AND (CONCAT(brand, ' ', line, ' ', model) LIKE CONCAT('%',?,'%') OR REPLACE(model, '-', ' ') LIKE CONCAT('%',?,'%') OR REPLACE(brand, '-', ' ') LIKE CONCAT('%',?,'%') OR REPLACE(line, '-', ' ') LIKE CONCAT('%',?,'%')) AND o.offerID NOT IN (SELECT offers.offerID FROM offers, transactions WHERE offers.offerID = transactions.itemID AND o.sellerID = offers.sellerID AND transactions.status != 'cancelled') GROUP BY p.model ORDER BY p.model ASC LIMIT 4;");
    $getCloset->bind_param("issss", $uid, $q, $q, $q, $q);
    $getCloset->execute();
    $getCloset->bind_result($productID, $model, $assetURL, $min, $numListed);

    while($getCloset->fetch()) {
        if($min === null) {
            $low = '';
        } else {
            $low = usdTocad($min, $db, true).'+';
        }

        if($numListed > 1) {
            $numListed = $numListed.' Pairs';
        } else {
            $numListed = $numListed. ' Pair';
        }

        if(isset($_SESSION['uid'])) {
            if($_SESSION['uid'] == $uid) {
                $onclick = 'onclick="editListing('."'".$productID."'".', '."'".$model."'".')"';
            } else {
                $onclick = '';
            }
        } else {
            $onclick = '';
        }

        echo '
        <div class="card">
            <table>
                <tr class="lowest_price" '.$onclick.'>
                    <td>'.$low.'</td>
                </tr>
                <tr class="item_asset" '.$onclick.'>
                    <td><img src="'.$assetURL.'" alt="'.$model.'"></td>
                </tr>
                <tr class="item_model" '.$onclick.'>
                    <td>'.$model.'</td>
                </tr>
                <tr style="color: #555;">
                <td>'.$numListed.'</td>
                </tr>
            </table>
        </div>
        ';
    }
?>