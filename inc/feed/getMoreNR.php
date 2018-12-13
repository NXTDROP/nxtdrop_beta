<?php
    session_start();
    include '../../dbh.php';
    $db = '../../dbh.php';
    require_once('../currencyConversion.php');
    date_default_timezone_set("UTC");
    $date = date("Y-m-d H:i:s", time());
    $num = $_POST['num'];
    $dateToday = date("Y-m-d", time());
    if(isset($_SESSION['uid'])) {
        $getNewReleases = $conn->prepare("SELECT products.productID, products.model, products.assetURL, (SELECT COUNT(*) FROM heat WHERE productID = products.productID) AS heat, (SELECT COUNT(*) FROM cold WHERE productID = products.productID) AS cold, (SELECT MIN(price) FROM offers WHERE offers.productID = products.productID AND price NOT IN (SELECT price FROM offers, transactions WHERE offers.productID = products.productID AND offers.offerID = transactions.itemID)) AS minPrice, (SELECT COUNT(userID) FROM heat WHERE userID = ? AND heat.productID = products.productID) AS heated, (SELECT COUNT(userID) FROM cold WHERE userID = ? AND cold.productID = products.productID) AS froze FROM products WHERE products.yearMade <= ? ORDER BY products.yearMade DESC LIMIT ?, 12;");
        $getNewReleases->bind_param("iisi", $_SESSION['uid'], $_SESSION['uid'], $dateToday, $num);
        $getNewReleases->execute();
        $getNewReleases->bind_result($productID, $model, $assetURL, $heat, $cold, $min, $heated, $froze);
    } else {
        $getNewReleases = $conn->prepare("SELECT products.productID, products.model, products.assetURL, (SELECT COUNT(*) FROM heat WHERE productID = products.productID) AS heat, (SELECT COUNT(*) FROM cold WHERE productID = products.productID) AS cold, (SELECT MIN(price) FROM offers WHERE offers.productID = products.productID AND price NOT IN (SELECT price FROM offers, transactions WHERE offers.productID = products.productID AND offers.offerID = transactions.itemID)) AS minPrice FROM products WHERE products.yearMade <= ? ORDER BY products.yearMade DESC LIMIT ?, 12;");
        $getNewReleases->bind_param("si", $dateToday, $num);
        $getNewReleases->execute();
        $getNewReleases->bind_result($productID, $model, $assetURL, $heat, $cold, $min);
    }

    while($getNewReleases->fetch()) {
        if($min === null) {
            $low = '';
        } else {
            $low = usdTocad($min, $db, true).'+';
        }

        if(isset($_SESSION['uid'])) {
            if($heated > 0) {
                $statsClass = 'class="num_stats_v"';
                $heatedClass = 'heated';
                $frozeClass = 'cold';
            } else if($froze > 0) {
                $statsClass = 'class="num_stats_v"';
                $frozeClass = 'froze';
                $heatedClass = 'heat';
            } else {
                $statsClass = 'class="num_stats_h"';
                $heatedClass = 'heat';
                $frozeClass = 'cold';
            }
        } else {
            $statsClass = 'class="num_stats_h"';
            $heatedClass = 'heat';
            $frozeClass = 'cold';
        }

        echo '
    <div class="card">
        <table>
            <tr class="lowest_price" onclick="item('."'".$productID."'".')">
                <td>'.$low.'</td>
            </tr>
            <tr class="item_asset" onclick="item('."'".$productID."'".')">
                <td><img src="'.$assetURL.'" alt="'.$model.'"></td>
            </tr>
            <tr class="item_stats stats-'.$productID.'">
                <td>
                    <table style="width: 100%;">
                        <tr '.$statsClass.' id="stats-'.$productID.'">
                            <td style="width: 50%;" class="heat_stats" id="heat-stats-'.$productID.'">'.$heat.'</td>
                            <td style="width: 50%;" class="cold_stats" id="cold-stats-'.$productID.'">'.$cold.'</td>
                        </tr>
                        <tr>
                            <td style="width: 50%;"><i class="fas fa-fire '.$heatedClass.'" title="Heat" id="heat-'.$productID.'" onclick="heat('.$productID.');"></i></td>
                            <td style="width: 50%;"><i class="fas fa-snowflake '.$frozeClass.'" title="Pass" id="cold-'.$productID.'" onclick="cold('.$productID.');"></i></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="item_model" onclick="item('."'".$productID."'".')">
                <td>'.$model.'</td>
            </tr>
        </table>
    </div>
    ';
    }

    $getNewReleases->close();

    
?>