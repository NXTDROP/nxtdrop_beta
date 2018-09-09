<script>
    var item_ID;
    var buyer_ID;
    var itemCondition;

    $(document).ready(function() {
        $('#authentic').click(function() {
            itemCondition = "OG";
            $('.pageone').fadeOut();
            $('.pagetwo').show();
        });

        $('#not_authentic').click(function() {
            itemCondition = "FAKE";
            $('.pageone').fadeOut();
            $('.pagetwo').show();
            $('#auth_comment').attr('placeholder', "Please tell us more about the item's condition.");
        });

        $('.done_btn').click(function() {
            /*$('.pagetwo').fadeOut();
            $('.pageone').show();
            $('.MM_Verif').fadeOut();
            $('.MM_Verif_main').fadeOut();*/
            var comment = $('#auth_comment').val();
            $('#auth_btn').html('<i class="fas fa-circle-notch fa-spin"></i>');
            $.ajax({
                url: 'inc/notificationPopUp/MM_auth.php',
                type: 'POST',
                data: {comment: comment, item_ID: item_ID, buyer_ID: buyer_ID, itemCondition: itemCondition},
                success: function(response) {
                    if(response === '') {
                        $('#auth_btn').html('SHOES VERIFIED! THX! <i class="fas fa-check-circle" style="color: #3fdb44"></i>');
                        setTimeout(function() {
                            $('#auth_btn').html('DONE!');
                            $('.pagetwo').fadeOut();
                            $('.pageone').show();
                            $('.MM_Verif').fadeOut();
                            $('.MM_Verif_main').fadeOut();
                        }, 3000);

                    }
                    else if(response === 'DB') {
                        $('#MM_verif_msg').html("Could not connect you to the servers.");
                        $('#auth_btn').html('DONE!');
                        setTimeout(function () {$('#MM_verif_msg').html("");}, 3000);
                    }
                    else if(response === 'VERIFIED') {
                        $('#MM_verif_msg').html("We experienced an issue. Contact us at support@nxtdrop.com");
                        $('#auth_btn').html('DONE!');
                        console.log(response);
                        setTimeout(function () {$('#MM_verif_msg').html("");}, 3000);
                    }
                    else {
                        $('#MM_verif_msg').html("We experienced an issue. Contact us at support@nxtdrop.com");
                        $('#auth_btn').html('DONE!');
                        console.log(response);
                        setTimeout(function () {$('#MM_verif_msg').html("");}, 3000);
                    }
                },
                error: function(response) {

                }
            });
        });
    });

    function order_verification(item, pic, description, buyer) {
        item_ID = item;
        buyer_ID = buyer;
        $('.MM_Verif #item_pic').attr('src', pic);
        $('.MM_Verif #item_pic').attr('alt', description);
        $('.MM_Verif #item_pic').attr('title', description);
        $('.MM_Verif #description').html(description);
        $('.MM_Verif').fadeIn();
        $('.MM_Verif_main').show();
        $('.notif-main').fadeOut();
        $('.notif-pop').fadeOut();
    }
</script>

<style>
.MM_Verif {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    display: none;
}

.MM_Verif_close {
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    position: fixed;
    top: 0;
}

.MM_Verif_main {
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

.MM_Verif_main h2 {
    text-align: center;
    padding: 15px 0;
    margin: 0;
    font-weight: 800;
    font-size: 25px;
    background: #aa0000;
    color: #fff;
    border-radius: 8px;
}

.MM_Verif_content {
    background: #FAFAFA;
    padding: 10px;
    text-align: center;
    border-radius: 8px;
}

.MM_Verif_content p {
    font-size: 25px;
    font-weight: 800;
    margin: 10px 0 15px 0;
}
</style>

<div class="MM_Verif">
    <div class="MM_Verif_close close"></div>
    <div class="MM_Verif_main">
        <div class="MM_Verif_content pageone">
            <h2>Item</h2>
            <img src="" alt="" title="" id="item_pic">
            <p id="description"></p>
            <button id="authentic" value="confirmation">OG 100% Real <i class="fas fa-check-circle" style="color: #3fdb44"></i></button>
            <button id="not_authentic" value="cancellation">Fake <i class="fas fa-times-circle" style="color: #c41313"></i></button>
        </div>

        <div class="MM_Verif_content pagetwo">
            <h2>COMMENTS...</h2>
            <textarea type="text" id="auth_comment" placeholder="Anything about the shoes you would like to report?"></textarea>
            <button class="done_btn" id="auth_btn">DONE!</button>
            <p id="MM_verif_msg" style="text-align: center; color: red;"></p>
        </div>
    </div>
</div>