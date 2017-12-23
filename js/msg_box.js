$(document).ready(function() {
    $(".close").click(function()
    {
        $('.msg_box').remove();
    });

    $('.msg_input').keydown(function(e) {
        var msg= $(this).val();
        if (e.keyCode == 13) {
            e.preventDefault();
            if (msg != "") {
                if (/\S/.test(msg)) {
                    $(this).val("");
                    $("<div class='msg_a'>"+msg+"</div>").insertBefore('.msg_insert');
                    $('#body').scrollTop($('#body')[0].scrollHeight);
                }
            }
        }
    });

    $('.msg_input').on('keydown', function(){
        $(this).val($(this).val().replace(/[\r\n\v]+/g, ''));
    });
});

function send() {
    var msg = $('.msg_input').val();
    if (msg != "") {
        if (/\S/.test(msg)) {
            $(this).val("");
            $("<div class='msg_a'>"+msg+"</div>").insertBefore('.msg_insert');
            $('#body').scrollTop($('#body')[0].scrollHeight);
            $('.msg_input').val('');
        }
    }
}