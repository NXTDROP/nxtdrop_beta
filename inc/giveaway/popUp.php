<style>
.giveaway {
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    display: none;
}

.giveaway_close {
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    position: fixed;
    top: 0;
}

.giveaway_main {
    width: 40%;
    height: auto;
    background: #fff;
    z-index: 15;
    position: fixed;
    top: 10%;
    left: 30%;
    padding-bottom: 5px;
    border-radius: 8px;
    display: none;
}

.giveaway_main h2 {
    text-align: center;
    padding: 15px 0;
    margin: 0;
    font-weight: 800;
    font-size: 25px;
    background: #aa0000;
    color: #fff;
    border-radius: 8px;
}

.giveaway_content {
    background: #FAFAFA;
    padding: 10px;
    text-align: center;
    border-radius: 8px;
}

.giveaway_content p {
    font-size: 16px;
    font-weight: 800;
    margin: 10px 0 15px 0;
}

.giveaway_content h4 {
    font-weight: 800;
}

.giveaway_content img {
    width: 80%;
    margin: 10px 10%;
}

.giveaway_content button {
    width: 80%;
    margin: 5px 10%;
    background: #aa0000;
    border: 1px solid #aa0000;
    padding: 5px;
    color: #fff;
    border-radius: 4px;
}

.giveaway_content button:hover {
    background: #fff;
    border: 1px solid #aa0000;
    color: #aa0000;
    cursor: pointer;
}

#giveaway_msg {
    font-size: 12px;
    font-weight: 500;
}

#floater {
    position: absolute;
    top: 93vh;
    right: 10px;
    padding: 10px;
    font-weight: 700;
    border-radius: 128px;
    font-size: 12px;
    background: #aa0000;
    color: #fff;
    z-index: 1;
}

#floater:hover {
    background: tomato;
    color: #fff;
    cursor: pointer;
}
</style>

<script type="text/javascript">
    function enterGiveaway() {
        $('.submit_giveaway').attr('disabled', true);
        $('.submit_giveaway').html('<i class="fas fa-circle-notch fa-spin"></i>');
        $.ajax({
            url: 'inc/giveaway/enter.php',
            type: 'POST',
            success: function(response) {
                if(response === 'CONNECT') {
                    window.location.replace('https://nxtdrop.com/');
                    $('.submit_giveaway').attr('disabled', false);
                    $('.submit_giveaway').html('Enter Giveaway');
                }
                else if(response === 'ENTERED') {
                    $('#giveaway_msg').html('You already entered the raffle. Invite a friend with your invite code to have 5x more chances to win.');
                    $('.submit_giveaway').attr('disabled', false);
                    setTimeout(function() {$('#giveaway_msg').html("");}, 10000);
                    $('.submit_giveaway').html('Enter Giveaway');
                }
                else if(response === 'GOOD') {
                    $('#giveaway_msg').html("Thank you for entering this month's giveaway!");
                    $('.submit_giveaway').attr('disabled', false);
                    setTimeout(function() {$('#giveaway_msg').html(""); $(".giveaway").fadeOut(); $(".giveaway_main").fadeOut(); $("#floater").fadeOut();}, 5000);
                    $('.submit_giveaway').html('Enter Giveaway');
                }
                else if(response === 'ERROR') {
                    $('#giveaway_msg').html("Sorry, there is a problem. Try again later!");
                    $('.submit_giveaway').attr('disabled', false);
                    setTimeout(function() {$('#giveaway_msg').html("");}, 10000);
                    $('.submit_giveaway').html('Enter Giveaway');
                    console.log(response);
                }
                else {
                    $('#giveaway_msg').html("Sorry, there is a problem. Try later!");
                    $('.submit_giveaway').attr('disabled', false);
                    setTimeout(function() {$('#giveaway_msg').html("");}, 10000);
                    $('.submit_giveaway').html('Enter Giveaway');
                    console.log(response);
                }
            }, 
            error: function() {
                $('#giveaway_msg').html("Sorry, there is a problem. Try again later!");
                $('.submit_giveaway').attr('disabled', false);
                setTimeout(function() {$('#giveaway_msg').html("");}, 10000);
                $('.submit_giveaway').html('Enter Giveaway');
                console.log(response);
            }
        });
    }

    function check() {
        $.ajax({
            url: 'inc/giveaway/check.php',
            type: 'POST',
            success: function(response) {
                console.log(response);
                if(response === 'false') {
                    $(".giveaway").fadeIn(); 
                    $(".giveaway_main").show();
                }
                else if(response === 'true') {
                    
                }
                else {
                    setTimeout(function() {$(".giveaway").fadeIn(); $(".giveaway_main").show();}, 6660);
                    console.log('else');
                }
            },
            error: function() {
                setTimeout(function() {$(".giveaway").fadeIn(); $(".giveaway_main").show();}, 6660);
                console.log('error');
            }
        });
    }

    $(document).ready(function() {
        check();

        $(window).scroll(function() {
            var winScrollTop = $(window).scrollTop();
            var winHeight = $(window).height();
            var floaterHeight = $('#floater').outerHeight(true);
            //true so the function takes margins into account
            var fromBottom = 20;

            var top = winScrollTop + winHeight - floaterHeight - fromBottom;
            $('#floater').css({'top': top + 'px'});
        });

        $(".close").click(function(){
            $(".giveaway").fadeOut();
            $(".giveaway_main").fadeOut();
        });

        $('#floater').click(function() {
            $(".giveaway").fadeIn(); 
            $(".giveaway_main").show();
        });
    });
</script>

<div class="giveaway">
    <div class="giveaway_close close"></div>
    <div class="giveaway_main">
    <h2 id="giveaway_title">ENTER GIVEAWAY</h2>
        <div class="giveaway_content">
            <h4>This month's giveaway:</h4>
            <img src="https://nxtdrop.com/img/cactusjack4.jpg" alt="Air Jordan 4s Cactus Jack">
            <p>Air Jordan 4s "Cactus Jack"</p>
            <p id="giveaway_msg"></p>
            <button class="submit_giveaway" onclick="enterGiveaway();">Enter Giveaway</button>
        </div>
    </div>
</div>

<div id="floater">Enter Giveaway</div>