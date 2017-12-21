$(document).ready(function(){
    $('.msg_box').hide();

    $(".close").click(function()
    {
        $('.msg_box').hide();
    });

    $('.msg_input').keydown(function(e) {
        var msg= $(this).val();
        if (e.keyCode == 13 && msg != "") {
            var id = this.id;
            $(this).val("");
            $("<div class='msg_a'>"+msg+"</div>").insertBefore('.msg_insert'+id);
            $('#body'+id).scrollTop($('#body'+id)[0].scrollHeight);
        }
    });

    $('.msg_input').on('keyup', function(){
        $(this).val($(this).val().replace(/[\r\n\v]+/g, ''));
    });
});

function show(element) {
    $('.msg_box').hide();
    var id = element.id;
    $('#'+id).show();
    console.log(id);
}