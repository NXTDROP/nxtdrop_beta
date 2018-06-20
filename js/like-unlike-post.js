function like(id, pid, posted_by) {
    var likes =  parseInt($("#count-"+pid).html());
    if($("#"+id).hasClass("like")) {
        $("#"+id).attr("class", "far fa-heart like");
        $("#"+id).attr("class", "fas fa-heart unlike");
        $("#count-"+pid).html(likes+1);
        $.ajax({
            type: 'POST',
            url: 'post/like.php',
            data: {pid: pid, posted_by: posted_by, type: 'like'},
            success: function (result) {
                if (result == false) {
                    $("#"+id).attr("class", "fas fa-heart unlike");
                    $("#"+id).attr("class", "far fa-heart like");
                    $("#count-"+pid).html(likes);
                }
            },
            error: function(data) {
                alert("Error 101.");
                alert(data);
            }
        });
    }
    else if ($("#"+id).hasClass("unlike") && likes >= 1) {
        $("#"+id).attr("class", "fas fa-heart unlike");
        $("#"+id).attr("class", "far fa-heart like");
        $("#count-"+pid).html(likes-1);
        $.ajax({
            type: 'POST',
            url: 'post/like.php',
            data: {pid: pid, posted_by: posted_by, type: 'unlike'},
            success: function (result) {
                if (result == false) {
                    $("#"+id).attr("class", "far fa-heart like");
                    $("#"+id).attr("class", "fas fa-heart unlike");
                    $("#count-"+pid).html(likes);
                }
            },
            error: function(data) {
                alert("Error 101.");
                alert(data);
            }
        });
    }
}