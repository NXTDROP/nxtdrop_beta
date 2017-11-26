function like(id, pid, posted_by) {
    if($("#"+id).hasClass("fa-heart-o")) {
        $.ajax({
            type: 'POST',
            url: 'post/like.php',
            data: {pid: pid, posted_by: posted_by, type: 'like'},
            success: function () {
                $("#"+id).removeClass("fa-heart-o");
                $("#"+id).addClass("fa-heart");
            }
        });
    }
    else {
        $.ajax({
            type: 'POST',
            url: 'post/like.php',
            data: {pid: pid, posted_by: posted_by, type: 'unlike'},
            success: function () {
                $("#"+id).removeClass("fa-heart");
                $("#"+id).addClass("fa-heart-o");
            }
        });
    }
}