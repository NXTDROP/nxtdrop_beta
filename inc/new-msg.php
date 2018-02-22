<script>
    $(document).ready(function(){
        $('#to').keyup(function(){
            var name = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'inc/search_users.php',
                data: {name: name},
                success: function(data){
                    $('#result').fadeIn();
                    $('#result').html(data);
                }
            });
        });

        $('#send').click(function(){
            var msg = $('.new_msg_input').val();
            var to = $('#to').val();
            $.post('inc/send_newmsg.php', {to: to, msg: msg}, function(data){
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

        $(document).on('click', '.user_r', function() {
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
                <h3 id="send_to">Send Message To:</h3></br>
                <form mehtod="POST" action="#">
                    <input type="text" id="to" name="to" autocomplete="off" spellcheck="false" placeholder="Enter a name" required/>
                </form>
                <div id="result"></div>
                <textarea class="new_msg_input" placeholder="Enter Message..." required></textarea>
                <p id="error_msg"></p>
                <button type="submit" name="send" id="send">Send Message</button>
        </div>
    </div>       
</div>