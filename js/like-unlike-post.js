function like(id, pid, posted_by, likes) {
    if($("#"+id).hasClass("fa-heart-o")) {
        $.ajax({
            type: 'POST',
            url: 'post/like.php',
            data: {pid: pid, posted_by: posted_by, type: 'like'},
            success: function (result) {
                $("#"+id).removeClass("fa-heart-o");
                $("#"+id).addClass("fa-heart");
                $("#likes-"+pid).attr('count', result);
            },
            error: function(data) {
                alert("Error 101.");
                alert(data);
            }
        });
    }
    else {
        $.ajax({
            type: 'POST',
            url: 'post/like.php',
            data: {pid: pid, posted_by: posted_by, type: 'unlike'},
            success: function (result) {
                $("#"+id).removeClass("fa-heart");
                $("#"+id).addClass("fa-heart-o");
                $("#likes-"+pid).attr('count', result);
            },
            error: function(data) {
                alert("Error 101.");
                alert(data);
            }
        });
    }
}