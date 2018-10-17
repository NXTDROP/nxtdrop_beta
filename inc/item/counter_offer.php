<script>
    var cOfferID = 0;
    var iprice = 0;
    $(document).ready(function(){
        $("#item_price-input").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                // Allow: Ctrl/cmd+A
                (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: Ctrl/cmd+C
                (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: Ctrl/cmd+X
                (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

        $("#send_counter").click(function() {
            var price = $('#item_price-input').val();
            //alert('Condition: ' + condition + '\n ProductID: ' + productID + '\n Price: ' + price + '\n Size: ' + size);
            if(price <= 0) {
                alert('Please enter a price.');
            } else if(price < iprice * 0.55) {
                var c = confirm('Your counter-offer seems too low. Do you want to continue?');
                if(c == true) {
                    sendCounter(cOfferID, price);
                }
            }
            else {
                sendCounter(cOfferID, price);
            }
        });
                
        $(".close").click(function(){
            $(".transaction_pop").fadeOut();
            $(".transaction_main").fadeOut();
            $('#item_price-input').val('');
            $('#item_price-input').attr('placeholder', 'Enter Price');  
        });

        $('#cancel_counter').click(function() {
            $(".transaction_pop").fadeOut();
            $(".transaction_main").fadeOut();
            $('#item_price-input').val('');
            $('#item_price-input').attr('placeholder', 'Enter Price');
        });
    });

    function sendCounter(ID, Price) {
        $("#send_counter").html('<i class="fas fa-circle-notch fa-spin"></i>');
        $.ajax({
            url: 'inc/item/sendCounterOffer.php',
            type: 'POST',
            data: {price: Price, offerID: ID},
            success: function(response) {
                console.log(response);
                if(response === 'CONNECTION') {
                    alert('Log in or Sign Up to sell.');
                } else if(response === 'DB') {
                    $('#send_counter').html('Error. Try again.');
                    setTimeout(() => {
                        $('#send_counter').html('Send Offer');
                    }, 5000);
                } else if(response === 'GOOD') {
                    $('#send_counter').html('Sent!');
                    $('#item_price-input').val('');
                    $('#item_price-input').attr('placeholder', 'Enter Price');
                    setTimeout(() => {
                        $('#send_counter').html('Send Offer');
                        $(".transaction_pop").fadeOut();
                        $(".transaction_main").fadeOut();
                    }, 2500);
                } else if (response === 'MISSING') {
                    $('#send_counter').html('Blank Price field.');
                    setTimeout(() => {
                        $('#send_counter').html('Send Offer');
                    }, 5000);
                } else {
                    console.log(response);
                    $('#send_counter').html('Error. Try later.');
                    setTimeout(() => {
                        $('#send_counter').html('Send Offer');
                    }, 5000);
                }
            },
            error: function() {
                console.log(response);
                alert('We encountered a problem. Please try later or contact support@nxtdrop.com');
            }
        });
    }
</script>

<?php
    if(isset($_SESSION['country'])) {
        if($_SESSION['country'] ==  'US') {
            $currency = '$';
        } elseif ($_SESSION['country']) {
            $currency = 'C$';
        } else {
            $currency = '$';
        }
    } else {
        $currency = '$';
    }
?>

<div class="transaction_pop">
    <div class="transaction_close close"></div>
    <div class="transaction_main">
        <h2>COUNTER-OFFER</h2>
        <div class="transaction_content">

            <div class="input-group mb-3 item_price">
                <div class="input-group-prepend">
                    <span class="input-group-text"><?php echo $currency; ?></span>
                </div>
                <input id="item_price-input" type="text" class="form-control" aria-label="Amount (to the nearest dollar)" placeholder="Enter Price">
                <div class="input-group-append">
                    <span class="input-group-text">.00</span>
                </div>
            </div><br>

            <button id="send_counter">SEND OFFER</button>
            <button id="cancel_counter">CANCEL</button>
            <p style="text-align: center; font-size: 10px;">Reminder: You can only send one counter-offer to this seller. But, you can try again if he declines.</p>
        </div>
    </div>       
</div>