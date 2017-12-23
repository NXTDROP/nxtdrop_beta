$(document).ready(function(){
    $('#to').focus(function(){
        $('#result').fadeIn();
        $('#result').show();
    });

    $('#to').blur(function(){
        $('#result').fadeOut();
        $('#result').hide();
    });
});

function show(to_from) {
    $('.msg_box').remove();
    $('.message').load("inc/msg_box.php", {to_from: to_from});
}