<?php
    if(!isset($_SESSION['uid'])) {
        $disabled = 'disabled';
    } else {
        $disabled = '';
    }

    $getNumTalks = $conn->prepare("SELECT COUNT(talkID) FROM talk;");
    $getNumTalks->execute();
    $getNumTalks->bind_result($numTalks);
    $getNumTalks->fetch();
    $getNumTalks->close();

    function newTime() {
        date_default_timezone_set("UTC"); 
        $_SESSION['talkTimestamp'] = date("Y-m-d H:i:s", time());
        return $_SESSION['talkTimestamp'];
    }

?>

<script>
    var total = <?php echo $numTalks; ?>;
    var count = 0;
    var offset;
    var scroll = false;
    var old_scroll = 0;
    var totalHeight = 0;
    $(document).ready(function() {
        $('.talk-header').click(function() {
            if($('.talk-popup').hasClass("hover")) {
                offset = count;
                count += 25;
                getTalks(count, offset);
                $('.talk-popup').removeClass("hover");
                $('.talk-popup').animate({
                    bottom: "0%",
                    opacity: 1,
                    width: "40%"
                }, 1000, function() {
                    $('.fa-angle-down').css('transform', 'rotate(0deg)');
                    if($('.talk-popup').hasClass('glow')) {
                        $('.talk-popup').removeClass('glow');
                        $('.talk-header > h2').html('NXTDROP CHAT');
                        $.ajax({
                            url: 'inc/talk/newStamp.php',
                            type: 'POST'
                        })
                    }
                });
            }
            else {
                $('.talk-popup').addClass("hover");
                offset = 0;
                count = 0;
                $('.talk-popup').animate({
                    bottom: "-83.6%",
                    opacity: 0.5,
                    width: "25%"
                }, 1000, function() {
                    $('.fa-angle-down').css('transform', 'rotate(180deg)');
                });
            }
        });

        $('.hover').hover(function() {
            $('.hover').css('opacity', '1');
            $('.hover').css('cursor', 'pointer');
        }, function() {
            $('.hover').css('opacity', '0.5');
            $('.hover').css('cursor', 'initial');
        });

        $('#talk-send').click(function() {
            var text = $('#talk-input').val();
            if(!isBlank(text) && !isEmpty(text)) {
                $.ajax({
                    url: 'inc/talk/send.php',
                    type: 'POST',
                    data: {text: text},
                    success: function(response) {
                        if(response === 'CONNECTION') {
                            alert('Log in or Sign up to use NXTDROP Chat.');
                        } else if(response === 'TEXT') {
                            alert('Enter text to send.');
                        } else if(response === 'DB') {
                            alert('We encoutering problems with our servers. Please, try later.');
                        } else {
                            if(jsonObject = JSON.parse(response)) {
                                $('<div class="talk-msg"><a href="u/' + jsonObject[0]['username'] + '">' + jsonObject[0]['username'] + '</a><span class="talk-time">@ ' + jsonObject[0]['date'] + '</span><br><img src="'+ $('#nav-profile').attr('src') + '" alt="" title="' + jsonObject[0]['username'] + '"><span>' + jsonObject[0]['text'] + '</span></div>').insertBefore('#last');
                                $('#talk-input').val('');
                                $('.talk-messages').animate({scrollTop: $('.talk-messages')[0].scrollHeight}, 1000);
                            } else {
                                alert('We had a problem. Try later.');
                            }
                        }
                    },
                    error: function(response) {
                        console.log(response);
                        alert('We had a problem. Try later.');
                    }
                });
            }
        });

        $('.talk-messages').scroll(function() {
            if($('.talk-messages').scrollTop() < 250 && count < total && scroll) {
                scroll = false;
                offset = count;
                count += 25;
                old_scroll = $(this).scrollTop(); //remember the scroll position
                $.ajax({
                    url: 'inc/talk/moreTalks.php',
                    type: 'POST',
                    data: {count: count, offset: offset},
                    success: function(response) {
                        console.log(response);
                        if(response === 'DB') {
                            alert('We encoutering problems with our servers. Please, try later.');
                        } else if(response === 'CONNECTION') {
                            console.log(response);
                        } else if(response === 'BANNED') {

                        } else {
                            $(response).insertAfter('#first');
                            $('.talk-messages').scrollTop(totalHeight - (old_scroll*1.5));
                            setTimeout(() => {
                                scroll = true;
                            }, 1000);
                        }
                    },
                    error: function(response) {
                        console.log(response);
                        alert('Sorry, we encoutered a problem. Service is down momentarily.');
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

    function getTalks(count, offset) {
        $.ajax({
            url: 'inc/talk/getTalks.php',
            type: 'POST',
            data: {count: count, offset: offset},
            success: function(response) {
                if(response === 'DB') {
                    alert('We encoutering problems with our servers. Please, try later.');
                } else if(response === 'CONNECTION') {
                    console.log(response);
                } else if(response === 'BANNED') {

                } else {
                    $('.talk-messages').html(response);
                    totalHeight = $('.talk-messages')[0].scrollHeight;
                    $('.talk-messages').animate({scrollTop: totalHeight}, 1000);
                    setTimeout(() => {
                        scroll = true;
                    }, 1000);
                }
            },
            error: function(response) {
                console.log(response);
                alert('Sorry, we encoutered a problem. Service is down momentarily.');
            }
        });
    }
</script>

<div class="talk-popup hover">
    <div class="talk-header">
        <h2>NXTDROP CHAT</h2>
        <i class="fas fa-angle-down"></i>
    </div>
    <div class="talk-messages">

    </div>
    <textarea name="input" id="talk-input" style="resize: none;" placeholder="Say 'Hi' to the community..." <?php echo $disabled; ?>></textarea>
    <button type="submit" name="send" id="talk-send" <?php echo $disabled; ?>>SEND</button>
</div>