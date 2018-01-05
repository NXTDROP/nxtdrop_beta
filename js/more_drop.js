$(document).ready(function() {
    var count = 1;
    $('.load_drop').click(function() {
        count += 1;
        alert(count);
        $.ajax({
            type: 'POST',
            url: 'inc/upload-more-drop.php',
            data: {count: count},
            success: function(data) {
                $('#posts-container').html(data);
            }
        });
    });
});