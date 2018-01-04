<script>
    var user_id;
    function send(uid) {
        user_id = uid;
    }

    $(document).ready(function(){
        $('#send').click(function(){
            var msg = $('.new_msg_input').val();
            var to = $('#to').val();
            $.post('inc/send_newmsg.php', {to: user_id, msg: msg}, function(data){
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

        $('.fa-envelope-o').click(function() {
            $(".msg_pop").fadeIn();
            $(".msg_main").show();
        });

        $(".close").click(function(){
            $(".msg_pop").fadeOut();
            $(".msg_main").fadeOut();
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
        <h2>New Message</h2>
        <div class="msg_content">
                <textarea class="new_msg_input" placeholder="Enter Message..." required></textarea>
                <p id="error_msg"></p>
                <button type="submit" name="send" id="send">Send Message</button>
        </div>
    </div>       
</div>