$(document).ready(function() {
    $("#cPwd").keyup(function() {
        var pwd = $("#pwd").val();
        var cPwd = $("#cPwd").val();

        $("#pwd, #cPwd").removeClass("input-error");
        $("#pwd, #cPwd").removeClass("input-success");

        if (pwd != cPwd) {
            $("#pwd, #cPwd").addClass("input-error");
        }
        else {
            $("#pwd, #cPwd").addClass("input-success");
        }
    });



    $("#signup").submit(function(event) {
        event.preventDefault();
        var pwd = $("#pwd").val();
        var cPwd = $("#cPwd").val();
        var submit = $("#submit").val();
        $("#form-message").load("newpwdregis.php", {
            cPwd: cPwd,
            pwd: pwd,
            email: email,
            hash: hash,
            submit: submit
        });
    });
});