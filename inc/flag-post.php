<script>
    var user_id;
    function flag(pid) {
        post_id = pid;
    }

    $(document).ready(function(){
        $('#send_report').click(function(){
            var report = $('.report_input').val();
            var confirmation = confirm('Do you really want to send this report?');
            if (confirmation ==  true) {
                $.post('inc/send_report.php', {pid: post_id, report: report}, function(data) {
                    if (data == '') {
                        $('.report_input').val('');
                        $('.flag_pop').fadeOut();
                        $('.flag_main').fadeOut();
                        $('#count').html('0').css('color', '#aa0000');
                        $('#error_report').html('');
                    }
                    else {
                        $('#error_report').html(data);
                    }
                });
            }
        });

        $('.fa-flag').click(function() {
            $(".flag_pop").fadeIn();
            $(".flag_main").show();
        });

        $(".close").click(function(){
            $(".flag_pop").fadeOut();
            $(".flag_main").fadeOut();
        });

        $('.report_input').keyup(function() {
            var count = $('.report_input').val().length;
            $('#count').html(count);
            if (count > 255 || count == 0 || count < 0) {
                $('#count').css('color', '#aa0000');
            }
            else {
                $('#count').css('color', '#59ff82');
            }
        });
    });
</script>

<div class="flag_pop">
    <div class="flag_close close"></div>
    <div class="flag_main">
        <h2>Report</h2>
        <div class="flag_content">
            <textarea class="report_input" placeholder="Why are you reporting this drop? (255 Characters MAX.)" required></textarea>
            <p id="error_report"></p><br><br>
            <p id="count">0</p>
            <button type="submit" name="send" id="send_report">Send Report</button>
        </div>
    </div>       
</div>