$(document).ready(function() {
    $('.msg_input').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            numData = numData + 1;
            send();
        }
    });

    $(".close").click(function()
    {
        $('.msg_box').remove();
        $('body').load('messages.php');
        clearTimeout(renew);
    });

    $('.msg_input').on('keydown', function(){
        var img = $('.inputfiles').val();
        if (img == '') {
            $(this).val($(this).val().replace(/[\r\n\v]+/g, ''));
        }
    });

    $('.inputfiles').change(function() {
        previewBeforeSend(this);
        $('.preview').fadeIn();
        $('.preview_main').show();
    });

    $('.preview_close').click(function() {
        $(".preview").fadeOut();
        $(".preview_main").fadeOut();
    });
});

function previewBeforeSend (input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#preview_send').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function send() {
    var msg = $('.msg_input').val();
    var to = $('#u_tofrom').text();
    var file_data = $('.inputfiles').prop('files')[0];
    var form_data = new FormData();                     // Create a form
    form_data.append('file', file_data);           // append file to form
    var img = $('.inputfiles').val();
    if (msg != "") {
        if (/\S/.test(msg)) {
            form_data.append('msg', msg);
            form_data.append('to', to);
            $("<div class='msg_a'>"+msg+"</div>").insertBefore('.msg_insert');
            $('#body').scrollTop($('#body')[0].scrollHeight);
            $('.msg_input').val('');
            $('.inputfiles').val('');
            $.ajax({
                type: 'POST',
                url: 'inc/send_newmsg.php',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(data) {
                    numData = numData + 1;
                    console.log(data);
                    if (img != '') {
                        updateMsg();
                        $('.msg_body').animate({scrollTop: 5000}, 2500);
                    }
                }
            });
        }
    }
    else {
        var img = $('.inputfiles').val();
        if (img != '') {
            msg = '';
            form_data.append('msg', msg);
            form_data.append('to', to);
            $('#body').scrollTop($('#body')[0].scrollHeight);
            $('.msg_input').val('');
            $('.inputfiles').val('');
            $.ajax({
                type: 'POST',
                url: 'inc/send_newmsg.php',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(data) {
                    numData = numData + 1;
                    console.log(data);
                    updateMsg();
                    $('.msg_body').animate({scrollTop: 5000}, 2500);
                }
            });
        }
    }
    
}