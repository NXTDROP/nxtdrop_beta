<script>
    $(document).ready(function(){
        $('#to').keyup(function(){
            var name = $(this).val();
            console.log(name);
            $.post('inc/search_users.php', {name: name}, function(data){
                $('div#result').css({'display':'block'});
                $('div#result').html(data);
            });
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
                <button type="submit" name="send" id="send">Send Message</button>
        </div>
    </div>       
</div>