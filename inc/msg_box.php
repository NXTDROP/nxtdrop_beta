<?php
    session_start();
    include '../dbh.php';
    $to_from = $_POST['to_from'];
    $id = $_POST['id'];
    $username = $_SESSION['username'];
    $query = "SELECT COUNT(*) FROM messages WHERE chat_id = '$id';";
    $result = mysqli_fetch_array(mysqli_query($conn, $query));
    $numMsg = $result[0];
?>
<script type="text/javascript" src="js/msg_box.js"></script>
<script type="text/javascript">
var renew;
var numData =  9;
var scroll = true;

var scroll_t = $('.msg_body').scrollTop();
$('.msg_body').scroll(function() {
    if ($('.msg_body').html.length) {
        scroll_t = $('.msg_body').scrollTop();
    }
});

function updateMsg() {
    var id = <?php echo "'".$id."'"; ?>;
    $.ajax({
        type: 'POST',
        url: 'inc/update_msg.php',
        data: {id: id, numData: numData},
        success: function(data) {
            $('.msg_body').html(data);
            $('#'+id).attr('class', '');
        },
        complete: function(data) {
            if (scroll) {
                $('.msg_body').animate({scrollTop: 5000}, 2500);
                scroll = false;
            }
            else {
                $('.msg_body').scrollTop(scroll_t);
            }
            renew = setTimeout(function() {
                updateMsg();
            }, 5000);
        }
    });
}
updateMsg();

$(".msg_body").scroll(function() {
    if($(".msg_body").scrollTop() == $(".msg_body").height() - $(".msg_body").height() && numData < <?php echo $numMsg; ?>) {
        var id = <?php echo "'".$id."'"; ?>;
        numData = numData + 9;
        var height = $('.msg_body').height() + 150;
        $.ajax({
            type: 'POST',
            url: 'inc/update_msg.php',
            data: {id: id, numData: numData},
            success: function(data) {
                $('.msg_body').html(data);
            },
            complete: function(data) {
                $('.msg_body').animate({scrollTop: 75}, 250);
                renew = setTimeout(function() {
                    updateMsg(to_from);
                }, 5000);
            }
        });
    }
});

</script>

<?php
    echo '<div class="msg_box">
    <div class="msg_head"><p id="from"><a href="u/'.$to_from.'" id="u_tofrom">'.$to_from.'</a></p>
        <div class="close-box"><i class="fa fa-times" aria-hidden="true" title="Close Chat"></i></div>
    </div>
    <div class="msg_body" id="body">';
    echo '</div>
    <textarea class="msg_input" placeholder="Write a message..."></textarea>
    <i class="fa fa-paper-plane fa-lg" aria-hidden="true" onclick="send()"></i>
    <input type="file" name="file" id="file" class="inputfiles" accept="image/*" data-multiple-caption="{count} files selected" multiple />
    <label for="file"><i class="fa fa-picture-o" aria-hidden="true"></i></label>
    
</div>';
?>