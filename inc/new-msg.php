<script>
    var username;

    function select_user(u) {
        $('#user-'+username).css('background', '#fff');
        $('#user-'+u).css('background', '#aa0000');
        $('#to').val(u);
        username = u;
    }

    $(document).ready(function(){
        $('#to').keyup(function(){
            var name = $(this).val();
            $.ajax({
                type: 'GET',
                url: 'inc/new_msg_user_search.php',
                data: {name: name},
                success: function(data){
                    $('.new_msg_users').html(data);
                }
            });
        });

        $('#new_msg_send').click(function(){
            var msg = $('#msg_textarea').val();
            var to = $('#to').val();
            $.post('inc/send_newmsg.php', {to: to, msg: msg}, function(data){
                if (data == '') {
                    $('#to').val('');
                    $('#msg_textarea').val('');
                    $(".new_msg_pop").fadeOut();
                    $(".new_msg_main").fadeOut();
                    udpateBody();
                }
                else {
                    $('#error_msg').html(data);
                }
            });
        });

        $('#new_msg_cancel').click(function() {
            $('.new_msg_pop').fadeOut();
            $('.new_msg_main').fadeOut();
            $('#to').val('');
            $('#msg_textarea').val('');
        });
    });
</script>

<div class="new_msg_pop">
    <div class="new_msg_close close"></div>
    <div class="new_msg_main">
        <h2>New Message</h2>
        <div class="new_msg_content">
            <input type="text" name="to" id="to" placeholder="Search User...">

            <p>SELECT USER</p>

            <div class="new_msg_users">
                
            </div>
            
            <textarea name="msg" id="msg_textarea" placeholder="Enter Message..."></textarea>

            <button id="new_msg_cancel">CANCEL</button>
            <button id="new_msg_send">SEND</button><br>
            <p id="error_msg"></p>
        </div>
    </div>       
</div>