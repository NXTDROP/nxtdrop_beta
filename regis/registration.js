function redirectToProfile (u) {
    window.location.replace('u/'+u);
}

var name;
var email;

/*function sendConfirmation() {
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
}*/

$(document).ready(function() {
    $("#signup").submit(function(event) {
        event.preventDefault();
        $('#submit').html('<i class="fas fa-circle-notch fa-spin"></i>');
        //$('.regis').fadeIn();
        //$('.regis_main').show();
        name = $("#name").val();
        var username = $("#username").val();
        email = $("#email").val();
        var pwd = $("#pwd").val();
        var cpwd = $("#cpwd").val();
        var country = $(".country_select").val();
        var submit = $("#submit").val();
        var invite_code = $('#invite_code').val();

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
                $(this).html('Create Account');
            }
            else {
                var form_data = new FormData();
                form_data.append('name', name);
                form_data.append('username', username);
                form_data.append('email', email);
                form_data.append('pwd', pwd);
                form_data.append('submit', submit);
                form_data.append('invite_code', invite_code);
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
                            //sendConfirmation();
                            setTimeout(function() {
                                window.location.replace('https://nxtdrop.com/preferences');
                            }, 2000);
                            //console.log(data);
                        }
                        else if (data === 'EMAIL') {
                            console.log(data);
                            setTimeout(function() {
                                window.location.replace('https://nxtdrop.com/preferences');
                            }, 2000);
                        }
                        else if (data === 'INVALID EMAIL') {
                            $('#form-message').addClass('error').text('Your email is invalid.');
                            $('#submit').html('Create Account');
                            console.log(data);
                        }
                        else if (data === 'DB') {
                            console.log(data);
                            $('#form-message').addClass('error').text('Could not connect to the servers. Try later.');
                            $('#submit').html('Create Account');
                        }
                        else {
                            $('#form-message').addClass('error').text('We have a problem. Please try later.');
                            $('#submit').html('Create Account');
                            $('.regis').fadeOut();
                            $('.regis_main').fadeOut();
                            alert(data);
                        }
                    },
                    error: function(data) {
                        $('#form-message').addClass('error').text('We have a problem. Please try later.');
                        $('#submit').html('Create Account');
                        $('.regis').fadeOut();
                        $('.regis_main').fadeOut();
                        console.log(data);
                    }
                });
            }
        }
    });

    $("#social_submit").click(function() {
        $(this).html('<i class="fas fa-circle-notch fa-spin"></i>');
        var country = $('#social_country').val();
        var username = $('#social_username').val();
        var invite_code = $('#social_invite_code').val();

        if (country == "Select Country [REQUIRED]") {
            $("#social_country").addClass("select-error");
            $(this).html('Create Account');
        }
        else {
            var form_data = new FormData();
            form_data.append('name', name);
            form_data.append('username', username);
            form_data.append('email', email);
            form_data.append('country', country);
            form_data.append('invite_code', invite_code);
            form_data.append('submit', true);
            $.ajax({
                url: "regis/registrationViaSM.php",
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(data) {
                    if (data == '') {
                        $('#social_form-message').addClass('success').text("Account Created!");
                        $('#social_submit').html('Create Account');
                        //sendConfirmation();
                        setTimeout(function() {
                            $('.social_regis').fadeOut();
                            $('.social_regis_main').fadeOut();
                            window.location.replace('https://nxtdrop.com');
                        }, 2000);
                    }
                    else if(data === "ACCOUNT") {
                        $('#social_form-message').addClass('error').text('You already have an account.');
                        $('#social_submit').html('Create Account');
                        console.log(data);
                        setTimeout(function() {
                            $('.social_regis').fadeOut();
                            $('.social_regis_main').fadeOut();
                        }, 5000);
                    }
                    else if (data === 'EMAIL') {}
                    else if (data === 'INVALID EMAIL') {
                        $('#social_form-message').addClass('error').text('Your email is invalid.');
                        $('#social_submit').html('Create Account');
                        console.log(data);
                    }
                    else if (data === 'DB') {
                        $('#social_form-message').addClass('error').text('Could not connect to the servers. Try later.');
                        $('#social_submit').html('Create Account');
                        console.log(data);
                    }
                    else {
                        $('#social_form-message').addClass('error').text('We have a problem. Please try later.');
                        $('#social_submit').html('Create Account');
                        console.log(data);
                    }
                }
            });
        }
    });
});