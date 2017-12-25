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
    //$('.msg_box').remove();
    $.ajax({
        type: 'POST',
        url: 'inc/msg_box.php',
        data: {to_from: to_from},
        success: function(data) {
            $('.message').html(data);
            $('.fa-circle').attr('class', '');
        }
    });
    console.log('ajax called');   
}

/*$('.message').load(
    "inc/msg_box.php", 
    {to_from: to_from}, 
    function(responseTxt, statusTxt, xhr) {
        $('.fa-circle').attr('class', '');
    }
);*/