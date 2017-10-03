$(document).ready(function() {
    $("#signup").submit(function(event) {
        event.preventDefault();
        var fName = $("#fName").val();
        var lName = $("#lName").val();
        var uName = $("#uName").val();
        var email = $("#email").val();
        var pwd = $("#pwd").val();
        var submit = $("#submit").val();
        $("#form-message").load("regis/registration.php", {
            fName: fName,
            lName: lName,
            uName: uName,
            email: email,
            pwd: pwd,
            submit: submit
        });
    });
});