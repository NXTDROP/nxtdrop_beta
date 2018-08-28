function redirectToProfile (u) {
    window.location.replace('u/'+u);
}

function sendConfirmation() {
    $.ajax({
        url: 'regis/signin_confirmation.php',
        type: 'POST',
        success: function(data) {
            if(data != "ERROR") {
                $('.regis_main').html(data);
            }
            else {
                $('.regis_content').html('<strong>There was an error! But we got GOOD NEWS. You will receive an email from our support team with more details within 48 hours.</strong>')
            }
        }
    });
}

$(document).ready(function() {
    $("#signup").submit(function(event) {
        event.preventDefault();
        $('#submit').html('<i class="fas fa-circle-notch fa-spin"></i>');
        $('.regis').fadeIn();
        $('.regis_main').show();
        var name = $("#name").val();
        var username = $("#username").val();
        var email = $("#email").val();
        var pwd = $("#pwd").val();
        var cpwd = $("#cpwd").val();
        var country = $(".country_select").val();
        var submit = $("#submit").val();

        if (country == "Select Country [REQUIRED]") {
            $(".country_select").addClass("select-error");
            $('#submit').html('Create Account');
            $('.regis').fadeOut();
            $('.regis_main').fadeOUt();
        }
        else {
            if (cpwd != pwd) {
                $("#form-message").addClass("error").text("Passwords don't match!");
                $("#pwd, #cpwd").addClass("input-error");
                $('#submit').html('Create Account');
                $('.regis').fadeOut();
                $('.regis_main').fadeOUt();
            }
            else {
                var form_data = new FormData();
                form_data.append('name', name);
                form_data.append('username', username);
                form_data.append('email', email);
                form_data.append('pwd', pwd);
                form_data.append('submit', submit);
                form_data.append('country', country);
                $.ajax({
                    url: "regis/registration.php",
                    type: 'POST',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function(data) {
                        if (data == '') {
                            $('#name').val('');
                            $('#username').val('');
                            $('#email').val('');
                            $('#pwd').val('');
                            $('#cpwd').val('');
                            $('#form-message').addClass('success').text("Account Created!");
                            $('#submit').html('Create Account');
                            sendConfirmation();
                        }
                        else {
                            $('#form-message').addClass('error').text(data);
                            $('#submit').html('Create Account');
                            $('.regis').fadeOut();
                            $('.regis_main').fadeOUt();
                        }
                    }
                });
            }
        }
    });
});