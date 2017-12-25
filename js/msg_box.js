$(document).ready(function() {
    $(".close").click(function()
    {
        $('.msg_box').remove();
    });

    $('.msg_input').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            send(true);
        }
    });

    $('.msg_input').on('keydown', function(){
        $(this).val($(this).val().replace(/[\r\n\v]+/g, ''));
    });
});

function send(mode) {
    var msg = $('.msg_input').val();
    var to = $('#u_tofrom').text();
    if (mode == true) {
        if (msg != "") {
            if (/\S/.test(msg)) {
                $("<div class='msg_a'>"+msg+"</div>").insertBefore('.msg_insert');
                $('#body').scrollTop($('#body')[0].scrollHeight);
                $('.msg_input').val('');
                $.ajax({
                    type: 'POST',
                    url: 'inc/send_newmsg.php',
                    data: {to: to, msg: msg, new: 'false'},
                    success: function(data) {
                        $('#u_tofrom').html(data);
                    }
                });
            }
        }
    }
    else {
        if (msg != "") {
            if (/\S/.test(msg)) {
                $("<div class='msg_a'>"+msg+"</div>").insertBefore('.msg_insert');
                $('#body').scrollTop($('#body')[0].scrollHeight);
                $('.msg_input').val('');
                $.ajax({
                    type: 'POST',
                    url: 'inc/send_newmsg.php',
                    data: {to: to, msg: msg, new: 'false'},
                    success: function(data) {
                        $('#u_tofrom').html(data);
                    }
                });
            }
        }
    }
    
}