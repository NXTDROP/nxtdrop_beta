<script>
    var item_ID = <?php echo $_GET['item']; ?>;
    var transaction_ID = <?php echo $_GET['tID']; ?>;

    $(document).ready(function() {
        $('#shipping_btn').click(function() {
            var carrier = $('#carrier').val();
            var trackingNumber = $('#trackingNumber').val();
            $('#shipping_btn').html('<i class="fas fa-circle-notch fa-spin"></i>');
            console.log('Carrier: ' + carrier + '\n' + 'Tracking #: ' + trackingNumber);
            $.ajax({
                url: 'inc/notificationPopUp/shipping.php',
                type: 'POST',
                data: {carrier: carrier, trackingNumber: trackingNumber, item_ID: item_ID, transaction_ID: transaction_ID},
                success: function(response) {
                    if(response === '') {
                        $('#shipping_btn').html('THX! <i class="fas fa-check-circle" style="color: #3fdb44"></i>');
                        setTimeout(function() {
                            $('#shipping_btn').html('DONE!');
                            $('.pagetwo').fadeOut();
                            $('.pageone').show();
                            $('.shipping').fadeOut();
                            $('.shipping_main').fadeOut();
                        }, 3000);

                    }
                    else if(response === 'DB') {
                        $('#shipping_msg').html("Could not connect you to the servers.");
                        $('#shipping_btn').html('DONE!');
                        setTimeout(function () {$('#shipping_msg').html("");}, 3000);
                    }
                    else if(response === 'TRACKED') {
                        $('#shipping_msg').html("You cannot edit shipping details once submitted. If needed, contact us at support@nxtdrop.com.");
                        $('#shipping_btn').html('DONE!');
                        console.log(response);
                        setTimeout(function () {$('#shipping_msg').html("");}, 3000);
                    }
                    else if(response === 'test') {
                        $('#shipping_btn').html('DONE!');
                        console.log('test');
                    }
                    else {
                        $('#shipping_msg').html("We experienced an issue. Contact us at support@nxtdrop.com");
                        $('#shipping_btn').html('DONE!');
                        console.log(response);
                        setTimeout(function () {$('#shipping_msg').html("");}, 3000);
                    }
                },
                error: function(response) {
                    $('#shipping_msg').html("We experienced an issue. Contact us at support@nxtdrop.com");
                    $('#shipping_btn').html('DONE!');
                    console.log(response);
                    setTimeout(function () {$('#shipping_msg').html("");}, 3000);
                }
            });
        });
    });
</script>

<style>
.shipping {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
}

.shipping_close {
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    position: fixed;
    top: 0;
}

.shipping_main {
    width: 40%;
    height: auto;
    background: #fff;
    z-index: 15;
    position: fixed;
    top: 30%;
    left: 30%;
    padding-bottom: 5px;
    border-radius: 8px;
}

.shipping_main h2 {
    text-align: center;
    padding: 15px 0;
    margin: 0;
    font-weight: 800;
    font-size: 25px;
    background: #aa0000;
    color: #fff;
    border-radius: 8px;
}

.shipping_content {
    background: #FAFAFA;
    padding: 10px;
    text-align: center;
    border-radius: 8px;
}

.shipping_content p {
    font-size: 25px;
    font-weight: 800;
    margin: 10px 0 15px 0;
}
</style>

<div class="shipping">
    <div class="shipping_close close"></div>
    <div class="shipping_main">
        <div class="shipping_content">
            <select name="carrier" id="carrier">
                <option value="N/A" selected>Choose</option>
                <option value="UPS">UPS</option>
                <option value="FedEx">FedEx</option>
                <option value="USPS">USPS</option>
                <option value="Canada Post">Canada Post</option>
                <option value="Park Mail">Park Mail</option>
            </select>
            <input type="text" id="trackingNumber" Placeholder="Tracking #" required>
            <button id="shipping_btn">Done!</button>
            <p id="shipping_msg"></p>
        </div>
    </div>
</div>