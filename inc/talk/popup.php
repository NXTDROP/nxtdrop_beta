<script>
    $(document).ready(function() {
        $('.fa-angle-down').click(function() {
            if($('.talk-popup').hasClass("hover")) {
                $('.talk-popup').removeClass("hover");
                $('.talk-popup').animate({
                    bottom: "0%",
                    opacity: 1,
                    width: "40%"
                }, 1000, function() {
                    $('.fa-angle-down').css('transform', 'rotate(0deg)');
                });
            }
            else {
                $('.talk-popup').addClass("hover");
                $('.talk-popup').animate({
                    bottom: "-83.6%",
                    opacity: 0.5,
                    width: "25%"
                }, 1000, function() {
                    $('.fa-angle-down').css('transform', 'rotate(180deg)');
                });
            }
        });

        $('#talk-send').click(function() {
            var text = $('#talk-input').val();
            if(!isBlank(text) && !isEmpty(text)) {
                $.ajax({
                    url: 'inc/talk/send.php',
                    type: 'POST',
                    data: {text: text},
                    success: function(response) {
                        console.log(response);
                        if(response === 'CONNECTION') {
                            alert('Log in or Sign up to use NXTDROP Talk.');
                        } else if(response === 'TEXT') {
                            alert('Enter text to send.');
                        } else if(response === 'DB') {
                            alert('We encoutering problems with our servers. Please, try later.');
                        } else if(response === 'GOOD') {
                            alert('Nice.');
                            $('#talk-input').val('');
                        } else {
                            alert('We had a problem. Try later.');
                        }
                    },
                    error: function(response) {
                        console.log(response);
                        alert('We had a problem. Try later.');
                    }
                });
            }
        });
    });

    function isBlank(str) {
        return (!str || /^\s*$/.test(str));
    }

    function isEmpty(str) {
        return (!str || 0 === str.length);
    }
</script>

<?php
    if(!isset($_SESSION['uid'])) {
        $disabled = 'disabled';
    } else {
        $disabled = '';
    }
?>

<div class="talk-popup hover">
    <div class="talk-header">
        <h2>NXTDROP TALK</h2>
        <i class="fas fa-angle-down"></i>
    </div>
    <div class="talk-messages">
        <div class="talk-msg">
            <a href="#">momarcissex</a><span class="talk-time">@ 2:56:45am -- 09/25/18</span><br>
            <img src="uploads/user.png" alt="" title="momarcissex"><span>Hi, welcome to NXTDROP. I am the CTO, Momar.</span>
        </div>
        <div class="talk-msg opps">
            <a href="#">yusuf</a><span class="talk-time">@ 2:57:31am -- 09/25/18</span><br>
            <img src="uploads/user.png" alt="" title="momarcissex"><span>Hi, welcome to NXTDROP. I am the CTO, Yusuf.</span>
        </div>
        <div class="talk-msg">
            <a href="#">momarcissex</a><span class="talk-time">@ 2:58:03am -- 09/25/18</span><br>
            <img src="uploads/user.png" alt="" title="momarcissex"><span>Thank you for choosing NXTDROP!</span>
        </div>
    </div>
    <textarea name="input" id="talk-input" style="resize: none;" placeholder="Say 'Hi' to the community..." <?php echo $disabled; ?>></textarea>
    <button type="submit" name="send" id="talk-send" <?php echo $disabled; ?>>SEND</button>
</div>