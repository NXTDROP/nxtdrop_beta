<?php
    $uid = $_SESSION['uid'];
    $query = "SELECT stripe_id FROM users WHERE uid = '$uid'";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
    $acc_id = $result['stripe_id'];

    $account = \Stripe\Account::retrieve($acc_id);
    $card = $account['external_accounts']['data'];
    if (empty($card)) {
        $last4 = 'xxxx';
    }
    else {
        $last4 = $account['external_accounts']['data'][0]['last4'];
    }
?>

<style>
.payout {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    display: none;
}

.payout_close {
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    position: fixed;
    top: 0;
}

.payout_main {
    width: 40%;
    height: auto;
    background: #fff;
    z-index: 15;
    position: fixed;
    top: 23%;
    left: 30%;
    display: none;
    padding-bottom: 5px;
    border-radius: 8px;
}

.payout_main h2 {
    text-align: center;
    padding: 15px 0;
    margin: 0;
    font-weight: 800;
    font-size: 25px;
    background: #aa0000;
    color: #fff;
    border-radius: 8px;

}

.payout_content {
    background: #FAFAFA;
    padding: 10px;
    text-align: center;
    border-radius: 8px;
}

.payout_content input {
    width: 75%;
    margin: 0 12.5%;
    padding: 5px;
    border: solid 1px #cccccc;
}

.payout_content button {
    width: 50%;
    margin: 10px 25%;
    color: #fff;
    background: #aa0000;
    border: none;
    font-size: 12px;
    padding: 5px;
    border: solid 1px #e8e8e8;
    -webkit-transition: background-color 0.5s ease-out;
    -moz-transition: background-color 0.5s ease-out;
    -o-transition: background-color 0.5s ease-out;
    transition: background-color 0.5s ease-out;
}

.payout_content button:hover {
    background: #fff;
    color: #aa0000;
    cursor: pointer;
    border: solid 1px #aa0000;
}

.payout_content p {
    font-size: 25px;
    font-weight: 800;
    margin: 10px 0 15px 0;
}

.payout_content strong {
    font-size: 22px;
    margin: 0;
    color: #85bb65;
}

.payout_content span {
    font-size: 18px;
    font-weight: 700;
    margin-left: 15px;
}

.payout_content a {
    font-size: 14px;
}

.fa-credit-card {
    color: #aa0000;
}

#payout_response {
    font-size: 12px;
    font-weight: 600;
}
</style>
<script type="text/javascript">
    $(document).ready(function () {
        var last4 = <?php echo "'".$last4."'"; ?>;
        $(".close").click(function(){
            $(".payout").fadeOut();
            $(".payout_main").fadeOut();
        });

        $("#transfer_btn").click(function() {
            $("#transfer_btn").html('TRANSFERING FUNDS...');
            $.ajax({
                url: 'inc/dashboard/transfer_funds.php',
                type: 'POST',
                data: {type: tf_type, currency: <?php echo "'".$currrency_name."'"; ?>},
                success: function(data) {
                    if(data === '') {
                        $("#transfer_btn").html('TRANSFER DONE <i class="fas fa-check-circle" style="color: #3fdb44"></i>');
                        setTimeout(function() {$("#transfer_btn").html('TRANSFER NOW');}, 5000);
                    }
                    else if(data === 'DB') {
                        $("#transfer_btn").html('TRANSFER NOW');
                        $('#payout_response').html('Sorry, you cannot transfer your balance right now. Contact Support Team at support@nxtdrop.com');
                    }
                    else {
                        $("#transfer_btn").html('TRANSFER NOW');
                        $('#payout_response').html(data);
                    }
                }
            });
        });

        $('#change_destination').click(function() {
            window.location.href = "settings";
        });

        if (last4 == 'xxxx') {
            $('#transfer_btn').attr("disabled", "disabled");
            $('#transfer_btn').css("background", "#a3a3a3");
            $('#transfer_btn').css("color", "#fff");
            $('#transfer_btn').css("border", "1px solid #a3a3a3");
            $('#payout_response').html('You must add a card or bank account to enable payouts.');
            $('#change_destination').html('ADD CARD OR BANK ACCOUNT');
        }
    });
</script>

<div class="payout popup_window">
    <div class="payout_close close"></div>
    <div class="payout_main popup_window_main">
    <h2 id="payout_title"></h2>
        <div class="payout_content">
            <p>SEND</p>
            <strong><?php echo $currrency.$available_balance ?></strong>
            <p>To:</p>
            <p><i class="fas fa-piggy-bank fa-2x" style="color: #aa0000;"></i><span>&#8226&#8226 <?php echo $last4; ?></span></p>
            <button id="change_destination">CHANGE TRANSFER DESTINATION</button>
            <button id="transfer_btn">TRANSFER NOW</button>
            <p id='payout_response'></p>
        </div>
    </div>
</div>