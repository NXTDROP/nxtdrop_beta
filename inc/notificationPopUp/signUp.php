<style>
.pop {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    font-family: 'Ubuntu', sans-serif!important;
    display: none;
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

.img_discount {
    width: 50%;
    height: 100%;
    margin: 0;
    float: left;
}

.img_discount img {
    margin: 0;
    width: 100%;
    border-bottom-left-radius: 4px;
    border-top-left-radius: 4px;
}

.display_discount {
    width: 50%;
    height: 100%;
    margin: 0;
    float: left;
    padding: 5px;
}

.display_discount h3 {
    text-align: center;
}

.display_discount p {
    text-align: center;
}

#close {
    text-align: center;
    cursor: pointer;
    color: #ef7c7c;
    font-size: 0.7em;
}

#discount_message {
    font-size: 0.6em;
}
</style>

<script type="text/javascript">
    $(document).ready(function() {
        $('.close').click(function() {
            $('.pop').fadeOut();
            $('.pop_main').fadeOut();
        });

        $('#close').click(function() {
            $('.pop').fadeOut();
            $('.pop_main').fadeOut();
        });

        $('#40off').click(function() {
            $('#40off').html('<i class="fas fa-circle-notch fa-spin"></i>');
            $('#close').css('display', 'none');
            $.ajax({
                url: 'inc/giveaway/sendDiscount.php',
                type: 'POST',
                success: function(response) {
                    console.log(response);
                    if(response === 'CONNECTION') {
                        $('#discount_message').html('Log in/register to get $40 off.');
                        $('#40off').html('GET $40 off');
                    } else if(response === 'DB') {
                        $('#discount_message').html('We encoutered an error. Try Later or contact us at support@nxtdrop.com');
                        $('#40off').html('GET $40 off');
                    } else if(response === 'EXIST') {
                        $('#discount_message').html('You redeemed your $40 code already.');
                        $('#40off').html('GET $40 off');
                        setTimeout(() => {  
                            $('.pop').fadeOut();
                            $('.pop_main').fadeOut();
                        }, 4000);
                    } else if(response === 'EMAIL') {
                        $('#discount_message').html('We had issues sending you your code. Contact us support@nxtdrop.com, we got your code already.');
                        $('#40off').html('GET $40 off');
                    } else if(response === 'GOOD') {
                        $('#discount_message').html('We sent you an email with your $40 off code. Enjoy, Luv.');
                        $('#40off').html('GET $40 off');
                        setTimeout(() => {  
                            $('.pop').fadeOut();
                            $('.pop_main').fadeOut();
                        }, 2500);
                    } else {
                        $('#discount_message').html('We encoutered an error. Try Later or contact us at support@nxtdrop.com');
                        $('#40off').html('GET $40 off');
                    }
                }, 
                error: function(response) {
                    alert("Couldn't get you $40 off, sorry. Try later or contact support@nxtdrop.com to redeem your code");
                    $('#40off').html('GET $40 off');
                }
            });
        });
    });
</script>

<div class="pop">
    <div class="pop_close close"></div>
    <div class="pop_main">
        <div class="img_discount">
            <img src="img/trav.gif" alt="Air Jordan 4 'Cactus Jack'">
        </div>

        <div class="display_discount">
            <h3 style="font-size: 1.8em; font-weight: 700;">Register now and...</h3>
            <p style="font-size: 0.9em; font-weight: 400; margin: 5% 0;">Get $40 off and free shipping on your first purchase today</p>
            <?php
                if(isset($_SESSION['uid'])) {
                    echo '<button id="40off">Get $40 off</button>';
                } else {
                    echo '<a href="https://nxtdrop.com/signup"><button>Get $40 off</button></a>';
                }
            ?>
            <p style="font-size: 0.6em; margin: 5px 0;">This offer ends October 20th at 11:59pm. Don&apos;t miss out!</p>
            <p id="discount_message"></p>
            <p id="close">nah, i&apos;m good!</p>
        </div>
    </div>
</div>