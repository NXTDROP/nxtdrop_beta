<script>
    var display_type;
    var user_name;

    function follow_display(type) {
        display_type = type;
        user_name = $('#username').html();
        if (display_type == 0) {
            $('.follow_display_main h2').html('Followers');
        }
        else if (display_type == 1) {
            $('.follow_display_main h2').html('Following');
        }
        $.ajax({
            type: 'POST',
            url: 'inc/following_sys/follow_users_display.php',
            data: {display_type: display_type, username: user_name},
            success: function(data) {
                $('.follow_display_content').html(data);
            }
        });
        $(".follow_display").fadeIn();
        $(".follow_display_main").show();
    }

    function follow_sys(username) {
        var follower_username = username;
        $('#follow_button-'+follower_username).attr('disabled', true);
        var val = $('#follow_button-'+follower_username).html();
        if (val == '+ Follow') {
            var type = 'follow';
            $('#follow_button-'+follower_username).html('- Unfollow');
            $('#follow_button-'+follower_username).delay(2500).attr('id', 'unfollow');
            $.ajax({
                type: 'POST',
                url: 'inc/following_sys/follow_unfollow.php',
                data: {follower_username:username, type:type},
                success: function (data) {
                    if (data == '') {
                        $('#follow_button-'+follower_username).html('- Unfollow');
                        $('#follow_button-'+follower_username).delay(2500).attr('id', 'unfollow');
                        $('#follow_button-'+follower_username).attr('disabled', false);
                    }
                    else {
                        $('.follow_unfollow').html(data);
                        timeoutID = window.setTimeout(follow, 2500);
                        $('#follow_button-'+follower_username).attr('disabled', false);
                    }
                }
            });
        }
        else {
            var type = 'unfollow';
            $('#follow_button-'+follower_username).html('+ Follow');
            $('#follow_button-'+follower_username).delay(2500).attr('id', 'follow');
            $.ajax({
                type: 'POST',
                url: 'inc/following_sys/follow_unfollow.php',
                data: {follower_username:username, type:type},
                success: function (data) {
                    if (data == '') {
                        $('#follow_button-'+follower_username).html('+ Follow');
                        $('#follow_button-'+follower_username).delay(2500).attr('id', 'follow');
                        $('#follow_button-'+follower_username).attr('disabled', false);
                    }
                    else {
                        $('#follow_button-'+follower_username).html(data);
                        timeoutID = window.setTimeout(unfollow, 2500);
                        $('#follow_button-'+follower_username).attr('disabled', false);
                    }
                }
            });
        }
    }

    $(document).ready(function() {
        $('.close').click(function() {
            $('.follow_display').fadeOut(1000);
            $('.follow_display_main').fadeOut(1000);
            $('.follow_display_content').html('');
        });
    });
</script>

<div class="follow_display">
    <div class="follow_display_close close"></div>
    <div class="follow_display_main">
        <h2></h2>
        <div class="follow_display_content">
            
        </div>
    </div>       
</div>