<?php 
    session_start();
    include "dbh.php";
    require_once('vendor/autoload.php');
    \Stripe\Stripe::setApiKey("sk_test_zFMuyMBC60raTKDdLGzR4wdb");
    if (!isset($_SESSION['uid'])) {
        header("Location: welcome_home.php");
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <title>
        NXTDROP: The Fashion Trade Centre
    </title>

    <head>
        <?php include('inc/head.php'); ?>
        <!-- Javasripts -->
        <script>
            var tf_type;
            var num_transaction = 10;
            $(document).ready(function() {
                $('#load_transactions').click(function() {
                    $('#load_transactions').html('Loading...');
                    num_transaction += 10;
                    load_transactions(num_transaction);
                });

                $('#standard_payout_btn').click(function() {
                    $(".payout").fadeIn();
                    $(".payout_main").show();
                    $('#payout_title').html('STANDARD PAYOUT');
                    tf_type = 0;
                    $('#transfer_btn').attr('value', '0');
                });

                $('#instant_payout_btn').click(function() {
                    $(".payout").fadeIn();
                    $(".payout_main").show();
                    $('#payout_title').html('INSTANT PAYOUT');
                    tf_type = 1;
                    $('#transfer_btn').attr('value', '1');
                });

                $('#bank_cards').click(function() {
                    window.location.href = "account_settings.php";
                });
            });

            function load_transactions(num) {
                $.ajax({
                    url: "inc/dashboard/transaction_list.php",
                    type: "POST",
                    data: {transaction_num: num},
                    success: function(data) {
                        $('#t_list').html(data);
                        $('#load_transactions').html('More Transactions');
                    }
                });
            }
            load_transactions(num_transaction);
        </script>
    </head>

    <body>
        <?php include('inc/navbar/navbar.php'); ?>

        <?php
            $uid = $_SESSION['uid'];
            $query = "SELECT stripe_id FROM users WHERE uid = '$uid'";
            $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
            $acc_id = $result['stripe_id'];
            $balance = \Stripe\Balance::retrieve(array(
                "stripe_account" => $acc_id
            ));
            $currrency = $balance['available'][0]['currency'];
            if ($currrency == 'usd') {
                $currrency = 'US$';
                $currrency_name = "USD";
            }
            else {
                $currrency = 'CA$';
                $currrency_name = "CAD";
            }

            $available_balance = number_format($balance['available'][0]['amount']/100, 2, ".", ",");
            $pending_balance = number_format($balance['pending'][0]['amount']/100, 2, ".", ",");
        ?>

        <div class="balances">
            <div class="available_balance">
                <strong><?php echo $currrency.$available_balance ?></strong>
                <p>Available Balance (<?php echo $currrency_name ?>)</p>
            </div>
            <div class="funds_on_hold">
                <strong><?php echo $currrency.$pending_balance ?></strong>
                <p>Funds on Hold (<?php echo $currrency_name ?>)</p>
            </div>
        </div>

        <div class="payout_btns">
            <div class="standard_payout">
                <button id="standard_payout_btn">Standard Payout</button>
                <p>Send money to your bank account. Up to 2 business day to process.</p>
            </div>
            <div class="instant_payout">
                <button id="instant_payout_btn">Instant Payout</button>
                <p>Send money to your bank account in less than 30 minutes. Instant payouts cost 1.5% of the payout amount.</p>
            </div>
        </div>

        <button id="bank_cards">Bank & Cards Settings</button>

        <?php
            $sales_query = "SELECT * FROM transactions WHERE seller_ID = '$uid'";
            $purchases_query = "SELECT * FROM transactions WHERE buyer_ID = '$uid'";
            $sales_results = mysqli_query($conn, $sales_query);
            $purchases_results = mysqli_query($conn, $purchases_query);
            $total_sales = 0;
            $num_sales = 0;
            $total_purchases = 0;
            $num_purchases = 0;
            while ($sales_row = mysqli_fetch_assoc($sales_results)) {
                if ($sales_row['status'] == 'complete') {
                    $total_sales += $sales_row['price'];
                    $num_sales++;
                }
            }

            while ($purchases_row = mysqli_fetch_assoc($purchases_results)) {
                if ($purchases_row['status'] == 'complete') {
                    $total_purchases += $purchases_row['price'];
                    $num_purchases++;
                }
            }
        ?>

        <div class="user_stats">
            <div class="user_purchases">
                <h2>Purchases</h2>
                <p>Total (<?php echo $currrency_name ?>)</p>
                <strong><?php echo $currrency.number_format($total_purchases, 2, ",", ".") ?></strong>
                <p>Number of Purchases</p>
                <strong># <?php echo $num_purchases ?></strong>
            </div>
            <div class="user_sales">
                <h2>Sales</h2>
                <p>Total (<?php echo $currrency_name ?>)</p>
                <strong><?php echo $currrency.number_format($total_sales, 2, ",", ".") ?></strong>
                <p>Number of Sales</p>
                <strong># <?php echo $num_sales ?></strong>
            </div>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Price (in CA$)</th>
                    <th>Transaction Type</th>
                    <th>Transaction #</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody id="t_list">

            </tbody>
        </table>

        <button id="load_transactions">More Transactions</button>

        <?php include('inc/drop/new-drop-pop.php'); ?>
        <?php include('inc/search_pop.php') ?>
        <?php include('inc/buyer_transaction_confirmation.php') ?>
        <?php include('inc/dashboard/payout_pop.php') ?>
    </body>
</html>