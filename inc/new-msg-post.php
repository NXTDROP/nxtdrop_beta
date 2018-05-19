<script>
    var user_id;
    function send(uid, pid) {
        user_id = uid;
        post_id = pid;
        $(".msg_pop").fadeIn();
        $(".msg_main").show();
    }

    $(document).ready(function(){
        $('#send').click(function(){
            var msg = $('.new_msg_input').val();
            var to = $('#to').val();
            $.post('inc/send_newmsg.php', {to: user_id, msg: msg, post_id: post_id}, function(data){
                if (data == '') {
                    $('#to').val('');
                    $('.new_msg_input').val('');
                    $(".msg_pop").fadeOut();
                    $(".msg_main").fadeOut();
                }
                else {
                    $('#error_msg').html(data);
                }
            });
        });

        $(".close").click(function(){
            $(".msg_pop").fadeOut();
            $(".msg_main").fadeOut();
            $('#to').val('');
            $('.new_msg_input').val('');
        });

        $('#cancel').click(function() {
            $(".msg_pop").fadeOut();
            $(".msg_main").fadeOut();
            $('#to').val('');
            $('.new_msg_input').val('');
        });

        $(document).on('click', 'li', function() {
            $('#to').val($(this).text());
            $('#result').fadeOut();
        });
    });
</script>

<div class="msg_pop">
    <div class="msg_close close"></div>
    <div class="msg_main">
        <h2>Send Offer</h2>
        <div class="msg_content">
                <textarea class="new_msg_input" placeholder="What's your offer? (Ex: 'I offer you $____ for this hoodie.')" required></textarea>
                <p id="error_msg"></p>
                <button type="button" name="cancel" id="cancel">Cancel</button>
                <button type="submit" name="send" id="send">Send Offer</button>
        </div>
    </div>       
</div>