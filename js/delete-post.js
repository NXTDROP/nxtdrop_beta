function delete_(pid) {
    var conf = confirm("Are you sure?");
    if (conf) {
        $.ajax({
            type: "GET",
            url: "post/delete-post.php",
            data: "pid="+pid,
            success: function() {
                $(".post-"+pid).remove();
            }
        });
    }
}