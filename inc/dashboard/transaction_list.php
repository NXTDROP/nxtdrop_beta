<?php
    session_start();
    $db = '../../dbh.php';
    require_once('../currencyConversion.php');
    include $db;
    $uid = $_SESSION['uid'];
    $num = $_POST['transaction_num'];
    $transactions_query = "SELECT * FROM transactions, offers, products WHERE transactions.itemID = offers.offerID AND (transactions.sellerID = '$uid' OR transactions.buyerID = '$uid') AND offers.productID = products.productID ORDER BY transactions.purchaseDate DESC LIMIT $num;";
    $transactions_results = mysqli_query($conn, $transactions_query); 

    while ($transactions_row = mysqli_fetch_assoc($transactions_results)) {
        $itemID = $transactions_row['itemID'];
        $date = date_create($transactions_row['purchaseDate']);
        $date = date_add($date, date_interval_create_from_date_string("-5 hours"));
        $item = $transactions_row['model'];
        $price = $transactions_row['totalPrice'];

        if($_SESSION['country'] == 'US') {
            $price = '$'.$price;
        } else if($_SESSION['country'] == 'CA') {
            $price = usdTocad($price, $db, true);
        } else {
            $price = usdTocad($price, $db, true);
        }

        $transaction_num = $transactions_row['transactionID'];
        $status = $transactions_row['status'];
        if ($uid == $transactions_row['sellerID']) {
            $color = 'style="color: #85bb65"';
            $price = '+ '.$price;
            $transaction_type = "SALE";
        }
        else {
            $color = 'style="color: #ef0404"';
            $price = '- '.$price;
            $transaction_type = "PURCHASE";
        }

        $transactionProduct = '<a href="orderPlaced.php?transactionID='.$transaction_num.'">'.$item.'</a>';

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