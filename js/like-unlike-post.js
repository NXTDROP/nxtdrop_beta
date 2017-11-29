function like(id, pid, posted_by, likes) {
    if($("#"+id).hasClass("fa-heart-o")) {
        $.ajax({
            type: 'POST',
            url: 'post/like.php',
            data: {pid: pid, posted_by: posted_by, type: 'like'},
            dataType: 'json',
            success: function (result) {
                $("#"+id).removeClass("fa-heart-o");
                $("#"+id).addClass("fa-heart");
                $("#likes-"+pid).html(result['likes'] + ' <i class="fa fa-heart aria-hidden="true" style="color:#a8a8a8;"></i>');
            },
            error: function() {
                alert("error");
            }
        });
    }
    else {
        $.ajax({
            type: 'POST',
            url: 'post/like.php',
            data: {pid: pid, posted_by: posted_by, type: 'unlike'},
            dataType: 'json',
            success: function (result) {
                $("#"+id).removeClass("fa-heart");
                $("#"+id).addClass("fa-heart-o");
                $("#likes-"+pid).html(result['likes'] + ' <i class="fa fa-heart aria-hidden="true" style="color:#a8a8a8;"></i>');
            },
            error: function() {
                alert("error");
            }
        });
    }
}