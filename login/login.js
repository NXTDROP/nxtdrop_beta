var email;
$(document).ready(function() {
    $('#submit_login').click(function() {
        var username = $('input[name="username"]').val();
        var pwd = $('input[name="pwd"]').val();
        $.ajax({
            type: 'POST',
            url: 'login/login.php',
            data: {username: username, pwd: pwd},
            success: function(data) {
                if (data == '') {
                    window.location.replace('home');
                } else if(data === 'preferences') {
                    window.location.replace('preferences');
                }
                else {
                    $('.error_login').html(data).css('color', 'red');
                }
            }
        });
    });

    $('input[name="username"]').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            var username = $('input[name="username"]').val();
            var pwd = $('input[name="pwd"]').val();
            $.ajax({
                type: 'POST',
                url: 'login/login.php',
                data: {username: username, pwd: pwd},
                success: function(data) {
                    if (data == '') {
                        window.location.replace('home');
                    } else if(data === 'preferences') {
                        window.location.replace('preferences');
                    }
                    else {
                        $('.error_login').html(data).css('color', 'red');
                    }
                }
            });
        }
    });

    $('input[name="pwd"]').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            var username = $('input[name="username"]').val();
            var pwd = $('input[name="pwd"]').val();
            $.ajax({
                type: 'POST',
                url: 'login/login.php',
                data: {username: username, pwd: pwd},
                success: function(data) {
                    if (data == '') {
                        window.location.replace('home');
                    } else if(data === 'preferences') {
                        window.location.replace('preferences');
                    }
                    else {
                        $('.error_login').html(data).css('color', 'red');
                    }
                }
            });
        }
    });
});