<?php
    session_start();
    include '../../dbh.php';
    $uid = $_SESSION['uid'];
    $num = $_POST['transaction_num'];
    $transactions_query = "SELECT * FROM transactions, posts WHERE transactions.itemID = posts.pid AND (transactions.sellerID = '$uid' OR transactions.buyerID = '$uid') ORDER BY transactions.purchaseDate DESC LIMIT $num;";
    $transactions_results = mysqli_query($conn, $transactions_query); 
    echo 'work';

    while ($transactions_row = mysqli_fetch_assoc($transactions_results)) {
        $itemID = $transactions_row['itemID'];
        $date = date_create($transactions_row['purchaseDate']);
        $item = $transactions_row['caption'];
        $price = $transactions_row['totalPrice'];
        $transaction_num = $transactions_row['transactionID'];
        $status = $transactions_row['status'];
        if ($uid == $transactions_row['sellerID']) {
            $color = 'style="color: #85bb65"';
            $price = '+ $'.$price;
            $transaction_type = "SALE";
        }
        else {
            $color = 'style="color: #ef0404"';
            $price = '- $'.$price;
            $transaction_type = "PURCHASE";
        }

        $transactionProduct = '<a href="orderPlaced.php?item='.$itemID.'">'.$item.'</a>';

        echo '<tr>
            <td>'.$transactionProduct.'</td>
            <td '.$color.'>'.$price.'</td>
            <td>'.$transaction_type.'</td>
            <td>'.$transaction_num.'</td>
            <td>'.$status.'</td>
            <td>'.date_format($date, "M j Y g:iA").'</td>
        </tr>';
    }
?>