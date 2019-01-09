<style>
.pop {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    font-family: 'Ubuntu', sans-serif!important;
    display: none;
    z-index: 15;
}

.pop_close {
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    position: fixed;
    top: 0;
}

.pop_main {
    width: 50%;
    height: auto;
    background: #fff;
    z-index: 15;
    position: fixed;
    top: 30%;
    left: 25%;
    padding: 0;
    border-radius: 8px;
    display: none;
}

.pop_main h2 {
    text-align: center;
    padding: 10px 0;
    margin: 0;
    font-weight: 800;
    font-size: 25px;
    background: #aa0000;
    color: #fff;
    border-radius: 8px;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.CO_main {
    text-align: center;
}

.pop_main button {
    width: 50%;
    margin: 5px 25%;
    border: none;
    background: #aa0000;
    padding: 8px;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 2px;
    border-radius: 4px;
    cursor: pointer;
    border: 1px solid #aa0000;
    font-weight: 600;
    font-size: 11px;
}

.pop_main button:hover {
    background: #fff;
    color: #aa0000;
    border: 1px solid #aa0000;
}

#decline_CO {
    margin-bottom: 10px;
}
</style>

<script type="text/javascript">
    var CO_iprice;
    var CO_cprice;
    var CO_offerID;
    var CO_cUserID;
    var CO_model;
    $(document).ready(function() {
        $('.close').click(function() {
            $('.pop').fadeOut();
            $('.pop_main').fadeOut();
        });

        $('#close').click(function() {
            $('.pop').fadeOut();
            $('.pop_main').fadeOut();
        });

        $('#accept_CO').click(function() {
            $('.CO_main > h2').html('<i class="fas fa-circle-notch fa-spin"></i>');
            console.log('accepted offer');
            $.ajax({
                url: 'inc/item/sendCOConf.php',
                type: 'POST',
                data: {confirmation: 'accepted', offerID: CO_offerID, userID: CO_cUserID, price: CO_cprice},
                success: function(response) {
                    console.log(response);
                    if(response === 'DB') {
                        $('.CO_main > h2').html("Couldn't review. Try later.");
                        setTimeout(() => {
                            $('CO_main > h2').html("Counter-offer Review");
                        }, 2500);
                    } else if(response === 'CONNECTION') {
                        $('.CO_main > h2').html("Couldn't review. Try later.");
                        setTimeout(() => {
                            $('.CO_main > h2').html("Counter-offer Review");
                        }, 2500);
                    } else if(response === 'GOOD') {
                        $('.CO_main > h2').html("Confirmed! Don't ship until you receive a confirmation email please. Thanks!");
                        setTimeout(() => {
                            $('.pop').fadeOut();
                            $('.pop_main').fadeOut();
                        }, 5000);
                        setTimeout(() => {
                            $('.CO_main > h2').html("Counter-offer Review");
                        }, 5000);
                    } else {
                        $('.CO_main > h2').html("Couldn't review. Try later.");
                        setTimeout(() => {
                            $('.CO_main > h2').html("Counter-offer Review");
                        }, 2500);
                    }
                },
                error: function(response) {
                    $('.CO_main > h2').html("Couldn't review. Try later.");
                        setTimeout(() => {
                            $('.CO_main > h2').html("Counter-offer Review");
                        }, 2500);
                }
            });
        });

        $('#decline_CO').click(function() {
            $('.CO_main > h2').html('<i class="fas fa-circle-notch fa-spin"></i>');
            console.log('declined offer');
            $.ajax({
                url: 'inc/item/sendCOConf.php',
                type: 'POST',
                data: {confirmation: 'declined', offerID: CO_offerID, userID: CO_cUserID},
                success: function(response) {
                    console.log(response);
                    if(response === 'DB') {
                        $('.CO_main > h2').html("Couldn't review. Try later.");
                        setTimeout(() => {
                            $('CO_main > h2').html("Counter-offer Review");
                        }, 2500);
                    } else if(response === 'CONNECTION') {
                        $('.CO_main > h2').html("Couldn't review. Try later.");
                        setTimeout(() => {
                            $('.CO_main > h2').html("Counter-offer Review");
                        }, 2500);
                    } else if(response === 'GOOD') {
                        $('.pop').fadeOut();
                        $('.pop_main').fadeOut();
                        setTimeout(() => {
                            $('.CO_main > h2').html("Counter-offer Review");
                        }, 2500);
                    } else {
                        $('.CO_main > h2').html("Couldn't review. Try later.");
                        setTimeout(() => {
                            $('.CO_main > h2').html("Counter-offer Review");
                        }, 2500);
                    }
                },
                error: function(response) {
                    $('.CO_main > h2').html("Couldn't review. Try later.");
                        setTimeout(() => {
                            $('.CO_main > h2').html("Counter-offer Review");
                        }, 2500);
                }
            });
        });
    });
</script>

<div class="pop CO">
    <div class="pop_close close"></div>
    <div class="pop_main CO_main">
        <h2>Counter-offer Review</h2>
        <p id="initial_price"></p>
        <p id="counter_price"></p>
        <p id="model_CO"></p>
        <button id="accept_CO">Accept Offer</button>
        <button id="decline_CO">Decline offer</button>
    </div>
</div>