<script>
    var item_ID;
    var buyer_ID;

    $(document).ready(function() {
        $('#confirm_order').click(function() {
            $(this).html('<i class="fas fa-circle-notch fa-spin"></i>');
            var confirmation = $(this).val();
            $.ajax({
                url: 'inc/notificationPopUp/seller_order_confirmation.php',
                type: 'POST',
                data: {resType: confirmation, item_ID: item_ID, buyer_ID: buyer_ID},
                success: function(data) {
                    $('#confirm_order').html('Accept Order');
                    if(data === 'CONNECT') {
                        $('.pageone').fadeOut();
                        $('.pagefour').show();
                    }
                    else if(data === 'DB') {
                        $('.pageone').fadeOut();
                        $('.pagefour').show();
                        alert('We have a problem. Please try later.');
                    }
                    else if(data === 'SOLD') {
                        $('.pagetwo').fadeOut();
                        $('.pagethree').fadeOut();
                        $('.pagefour').fadeOut();
                        $('.pageone').show();
                        $('.seller_Conf').fadeOut();
                        $('.seller_Conf_main').fadeOut();
                        alert('You sold this item already. List it again if you have more stocks.');
                    }
                    else if(data === '') {
                        $('.pageone').fadeOut();
                        $('.pagetwo').show();
                    }
                    else {
                        $('.pageone').fadeOut();
                        $('.pagetwo').show();
                        alert(data);
                    }
                },
                error: function() {
                    $(this).html('Accept Order');
                    $('.pageone').fadeOut();
                    $('.pagefour').show();
                }
            });
        });

        $('#cancel_order').click(function() {
            $(this).html('<i class="fas fa-circle-notch fa-spin"></i>');
            var conf =  confirm('Are you sure you want to cancel this order?');
            var confirmation = $(this).val();
            alert(conf);
            if(conf) {
                $.ajax({
                    url: 'inc/notificationPopUp/seller_order_confirmation.php',
                    type: 'POST',
                    data: {resType: confirmation, item_ID: item_ID, buyer_ID: buyer_ID},
                    success: function(data) {
                        $('#cancel_order').html('Cancel Order');
                        if(data === 'CONNECT') {
                            $('.pageone').fadeOut();
                            $('.pagefour').show();
                        }
                        else if(data === 'DB') {
                            $('.pageone').fadeOut();
                            $('.pagefour').show();
                        }
                        else if(data === 'SOLD') {
                            $('.pagetwo').fadeOut();
                            $('.pagethree').fadeOut();
                            $('.pagefour').fadeOut();
                            $('.pageone').show();
                            $('.seller_Conf').fadeOut();
                            $('.seller_Conf_main').fadeOut();
                            alert('You sold this item already. List it again if you have more stocks.');
                        } else if(data === 'CARD') {
                            $('.pageone').fadeOut();
                            $('.pagefour').show();
                            $('#sellerConf_error').html("There is a problem on the buyer's side. We'll contact you via email once it is fixed. Thanks for you patience!");
                        }
                        else if(data === '') {
                            $('.pageone').fadeOut();
                            $('.pagethree').show();
                        }
                    },
                    error: function(data) {
                        $(this).html('Cancel Order');
                        $('.pageone').fadeOut();
                        $('.pagefour').show();
                    }
                });
            } else if(!conf) {
                $('#cancel_order').html('Cancel Order');
            }
        });

        $('.okay_btn').click(function() {
            $('.pagetwo').fadeOut();
            $('.pagethree').fadeOut();
            $('.pagefour').fadeOut();
            $('.pageone').show();
            $('.seller_Conf').fadeOut();
            $('.seller_Conf_main').fadeOut();
        });
    });

    function order_confirmation(item, pic, description, buyer) {
        item_ID = item;
        buyer_ID = buyer;
        $('#item_pic').attr('src', pic);
        $('#item_pic').attr('alt', description);
        $('#item_pic').attr('title', description);
        $('#description').html(description);
        $('.seller_Conf').fadeIn();
        $('.seller_Conf_main').show();
        $('.notif-main').fadeOut();
        $('.notif-pop').fadeOut();
    }
</script>

<style>
.seller_Conf {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    display: none;
}

.seller_Conf_close {
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    position: fixed;
    top: 0;
}

.seller_Conf_main {
    width: 40%;
    height: auto;
    background: #fff;
    z-index: 15;
    position: fixed;
    top: 75px;;
    left: 30%;
    padding-bottom: 5px;
    border-radius: 8px;
    display: none;
}

.seller_Conf_main h2 {
    text-align: center;
    padding: 15px 0;
    margin: 0;
    font-weight: 800;
    font-size: 25px;
    background: #aa0000;
    color: #fff;
    border-radius: 8px;
}

.seller_Conf_content {
    background: #FAFAFA;
    padding: 10px;
    text-align: center;
    border-radius: 8px;
}

.seller_Conf_content p {
    font-size: 25px;
    font-weight: 800;
    margin: 10px 0 15px 0;
}

.pagetwo {
    display: none;
}

.pagethree {
    display: none;
}

.pagefour {
    display: none;
}
</style>

<div class="seller_Conf">
    <div class="seller_Conf_close close"></div>
    <div class="seller_Conf_main popup_window_main">
        <div class="seller_Conf_content pageone">
            <h2>Item</h2>
            <img src="" alt="" title="" id="item_pic">
            <p id="description"></p>
            <button id="confirm_order" value="confirmation">Accept Order</button>
            <button id="cancel_order" value="cancellation">Cancel Order</button>
        </div>

        <div class="seller_Conf_content pagetwo">
            <h2>DEAL CONFIRMED!</h2>
            <p id="shipping_details">An email will be sent to you with the shipping details. Once you have received the email, you have 48 hours to ship us the shoes and update the shipping details. Otherwise, you risk a 15% penality.</p>
            <button class="okay_btn">OK!</button>
        </div>

        <div class="seller_Conf_content pagethree">
            <h2>DEAL CANCELLED!</h2>
            <p id="shipping_details">You cancelled the deal. We will inform the buyer. Thank you!</p>
            <button class="okay_btn">OK!</button>
        </div>

        <div class="seller_Conf_content pagefour">
            <h2>We are sorry!</h2>
            <p id="sellerConf_error">We have a problem. Please, try later again!</p>
            <button class="okay_btn">OK!</button>
        </div>
    </div>
</div>