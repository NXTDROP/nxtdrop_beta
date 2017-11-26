$(document).ready(function(){
    $('.msg_box').hide();
    $('.msg_box2').hide();

    $(".close").click(function()
    {
        $('.msg_box').hide();
    });

    $(".user ").click(function()
    {
        $('.msg_box').show();
        $('.msg_box2').hide();
    });

    $(".close2").click(function()
    {
        $('.msg_box2').hide();
    });

    $(".user 2").click(function()
    {
        $('.msg_box2').show();
        $('.msg_box').hide();
    });

    $('.msg_input').keypress(function(e) {
        if (e.keyCode == 13) {
            var msg= $(this).val();
            $(this).val("");
            $("<div class='msg_a'>"+msg+"</div>").insertBefore('.msg_insert');
            $('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);   
        }
    });

    $('.msg_input2').keypress(function(e) {
            if (e.keyCode == 13) {
                var msg= $(this).val();
                $(this).val("");
                $("<div class='msg_a2'>"+msg+"</div>").insertBefore('.msg_insert2');
                $('.msg_body2').scrollTop($('.msg_body2')[0].scrollHeight);   
            }
    });
});