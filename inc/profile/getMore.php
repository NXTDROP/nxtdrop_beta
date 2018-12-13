<?php
    session_start();
    include '../../dbh.php';
    date_default_timezone_set("UTC");
    $db = '../../dbh.php';
    require_once('../currencyConversion.php');
    
    $getCloset = $conn->prepare("SELECT p.productID, p.model, p.assetURL, MIN(o.price), COUNT(o.offerID) FROM users u, offers o, products p WHERE u.username = ? AND u.uid = o.sellerID AND o.productID = p.productID AND o.offerID NOT IN (SELECT transactions.itemID FROM offers, transactions WHERE offers.offerID = transactions.itemID AND o.sellerID = offers.sellerID AND transactions.status != 'cancelled') GROUP BY p.model ORDER BY p.model ASC LIMIT ?, 12;");
    $getCloset->bind_param("si", $username, $num);
    $username = $_POST['username'];
    $num = $_POST['num'];

    if($getCloset->execute()) {
        $getCloset->bind_result($productID, $model, $assetURL, $min, $numListeds);
        while($getCloset->fetch()) {
            if($min === null) {
                $low = '';
            } else {
                $low = usdTocad($min, $db, true).'+';
            }
    
            if($numListeds > 1) {
                $numListeds = $numListeds.' Pairs';
            } else {
                $numListeds = $numListeds. ' Pair';
            }
    
            if(isset($_SESSION['uid'])) {
                if($_SESSION['username'] == $username) {
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
                        <td>'.$numListeds.'</td>
                        </tr>
                    </table>
                </div>
                ';
            }
    
            $getCloset->close();
    } else {
        die('ERROR');
    }
    
?>