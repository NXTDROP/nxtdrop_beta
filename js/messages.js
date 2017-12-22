$(document).ready(function(){
    $('.msg_box').hide();

    $(".close").click(function()
    {
        $('.msg_box').hide();
    });

    $('.msg_input').keydown(function(e) {
        var msg= $(this).val();
        if (e.keyCode == 13) {
            e.preventDefault();
            if (msg != "") {
                if (/\S/.test(msg)) {
                    var id = this.id;
                    $(this).val("");
                    $("<div class='msg_a'>"+msg+"</div>").insertBefore('.msg_insert'+id);
                    $('#body'+id).scrollTop($('#body'+id)[0].scrollHeight);
                }
            }
        }
    });

    $('.msg_input').on('keydown', function(){
        $(this).val($(this).val().replace(/[\r\n\v]+/g, ''));
    });

    $('#to').focus(function(){
        $('#result').fadeIn();
        $('#result').show();
    });

    $('#to').blur(function(){
        $('#result').fadeOut();
        $('#result').hide();
    });
});

function show(element) {
    $('.msg_box').hide();
    var id = element.id;
    $('#'+id).show();
}

function send(ele) {
    var msg = $('#'+ele).val();
    if (msg != "") {
        if (/\S/.test(msg)) {
            $(this).val("");
            $("<div class='msg_a'>"+msg+"</div>").insertBefore('.msg_insert'+ele);
            $('#body'+ele).scrollTop($('#body'+ele)[0].scrollHeight);
            $('#'+ele).val('');
        }
    }
}