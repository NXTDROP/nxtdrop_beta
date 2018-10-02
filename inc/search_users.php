<?php

    session_start();
    include '../dbh.php';
    $getProducts = $conn->prepare("SELECT brand, model, assetURL, colorway, productID FROM products WHERE CONCAT(brand, ' ', line, ' ', model) LIKE CONCAT('%',?,'%') OR REPLACE(model, '-', ' ') LIKE CONCAT('%',?,'%') OR REPLACE(brand, '-', ' ') LIKE CONCAT('%',?,'%') OR REPLACE(line, '-', ' ') LIKE CONCAT('%',?,'%') OR REPLACE(colorway, '-', ' ') LIKE CONCAT('%',?,'%') ORDER BY yearMade DESC LIMIT 25;");
    $getProducts->bind_param("sssss", $search, $search, $search, $search, $search);

    if(!isset($_GET['search'])) {
        die('NO TEXT');
    } else {
        $search = $_GET['search'];
        
        if($getProducts->execute()) {
            $getProducts->bind_result($brand, $model, $assetURL, $colorway, $productID);
            while($getProducts->fetch()) {
                echo '<div class="sell_item-results" onclick="to_item('."'".$productID."'".')">
                        <div class="item_asset-results">
                            <img src="'.$assetURL.'" alt="'.$model.'" style="height: 100%;">
                        </div>
                        <div class="item_description-results">
                            <p style="font-weight: 700; font-size: 14px;">'.$brand.'</p>
                            <p style="font-weight: 700; font-size: 18px;">'.$model.'</p>
                            <p style="font-weight: 700; font-size: 14px;">'.$colorway.'</p>
                        </div>
                    </div>';
            }
        } else {
            die('DB');
        }
        
    }

?>