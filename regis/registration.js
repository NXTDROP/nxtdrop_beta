function redirectToProfile (u) {
    window.location.replace('u/'+u);
}

$(document).ready(function() {
    $("#signup").submit(function(event) {
        event.preventDefault();
        var name = $("#name").val();
        var username = $("#username").val();
        var email = $("#email").val();
        var pwd = $("#pwd").val();
        var cpwd = $("#cpwd").val();
        var country = $(".country_select").val();
        var submit = $("#submit").val();

        if (country == "Select Country [REQUIRED]") {
            $(".country_select").addClass("select-error");
        }
        else {
            if (cpwd != pwd) {
                $("#form-message").addClass("error").text("Passwords don't match!");
                $("#pwd, #cpwd").addClass("input-error");
            }
            else {
                var form_data = new FormData();
                form_data.append('name', name);
                form_data.append('username', username);
                form_data.append('email', email);
                form_data.append('pwd', pwd);
                form_data.append('submit', submit);
                form_data.append('country', country);
                $('#form-message').text("Creating your account...");
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
                            timeoutID = window.setTimeout(redirectToProfile(username), 2000);
                        }
                        else {
                            $('#form-message').addClass('error').text(data);
                        }
                    }
                });
            }
        }
    });
});