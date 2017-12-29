function delete_(pid) {
    var conf = confirm("You are about to delete this drop. Are you sure?");
    if (conf == true) {
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