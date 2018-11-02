<?php

    require_once('dbh.php');

    $getProduct = $conn->prepare("SELECT productID FROM products WHERE productID > 1000586;");
    $getProduct->execute();
    $getProduct->bind_result($productID);
    $rank = 381;
    $id = array();

    while($getProduct->fetch()) {
         array_push($id, $productID);
    }

    $getProduct->close();
    $len = count($id);

    $addToRank = $conn->prepare("INSERT INTO product_rank (productID, rank) VALUES (?, ?);");

    for($i = 0; $i < $len; $i++) {
        $rank++;
        $addToRank->bind_param('ii', $id[$i], $rank);
        if($addToRank->execute()) {
            echo 'ProductID: '.$id[$i].', Rank: '.$rank;
        }
    }

    $addToRank->close();

?>