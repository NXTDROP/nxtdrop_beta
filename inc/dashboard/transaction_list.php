<?php
    session_start();
    include '../dbh.php';
    $uid = $_SESSION['uid'];
    $num = $_POST['transaction_num'];
    $transactions_query = "SELECT * FROM transactions, posts WHERE transactions.post_ID = posts.pid AND (transactions.seller_ID = '$uid' OR transactions.buyer_ID = '$uid') ORDER BY transactions.date DESC LIMIT $num;";
    $transactions_results = mysqli_query($conn, $transactions_query); 
    echo 'work';

    while ($transactions_row = mysqli_fetch_assoc($transactions_results)) {
        $date = date_create($transactions_row['date']);
        $item = $transactions_row['caption'];
        $price = $transactions_row['price'];
        $transaction_num = $transactions_row['transaction_ID'];
        $status = $transactions_row['status'];
        if ($uid == $transactions_row['seller_ID']) {
            $color = 'style="color: #85bb65"';
            $price = '+ $'.$price;
            $transaction_type = "SALE";
        }
        else {
            $color = 'style="color: #ef0404"';
            $price = '- $'.$price;
            $transaction_type = "PURCHASE";
        }
        echo '<tr>
            <td>'.$item.'</td>
            <td '.$color.'>'.$price.'</td>
            <td>'.$transaction_type.'</td>
            <td>'.$transaction_num.'</td>
            <td>'.$status.'</td>
            <td>'.date_format($date, "M j Y g:iA").'</td>
        </tr>';
    }
?>