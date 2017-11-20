$(document).ready(function() {
    $("#signup").submit(function(event) {
        event.preventDefault();
        var fname = $("#fname").val();
        var lname = $("#lname").val();
        var username = $("#username").val();
        var email = $("#email").val();
        var pwd = $("#pwd").val();
        var cpwd = $("#cpwd").val();
        var submit = $("#submit").val();

        if (cpwd != pwd) {
            $("#form-message").addClass("error").text("Passwords don't match!");
            $("#pwd, #cpwd").addClass("input-error");
        }
        else {
            $("#form-message").load("regis/registration.php", {
                fname: fname,
                lname: lname,
                username: username,
                email: email,
                pwd: pwd,
                submit: submit
            });
        }
    });
});