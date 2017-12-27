<?php
    session_start();
    include 'dbh.php';
    $to_from = $_POST['to_from'];
    $username = $_SESSION['username'];
    $query = "SELECT COUNT(*) FROM messages WHERE u_to = '$to_from' AND u_from = '$username' OR u_to = '$username' AND u_from = '$to_from';";
    $result = mysqli_fetch_array(mysqli_query($conn, $query));
    $numMsg = $result[0];
?>
<script src="js/msg_box.js"></script>
<script>
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
    console.log('call updateMsg');
    var to_from = <?php echo "'".$_POST['to_from']."'"; ?>;
    $.ajax({
        type: 'POST',
        url: 'inc/update_msg.php',
        data: {to_from: to_from, numData: numData},
        success: function(data) {
            $('.msg_body').html(data);
            $('.fa-circle').attr('class', '');
            if (scroll) {
                $('.msg_body').scrollTop(1000);
                scroll = false;
            }
            else {
                $('.msg_body').scrollTop(scroll_t);
            }
        },
        complete: function(data) {
            renew = setTimeout(function() {
                updateMsg();
            }, 10000);
        }
    });
}

updateMsg();

$(".msg_body").scroll(function() {
    if($(".msg_body").scrollTop() == $(".msg_body").height() - $(".msg_body").height()) {
        var to_from = <?php echo "'".$_POST['to_from']."'"; ?>;
        numData = numData + 9;
        var height = $('.msg_body').height();
        $.ajax({
            type: 'POST',
            url: 'inc/update_msg.php',
            data: {to_from: to_from, numData: numData},
            success: function(data) {
                $('.msg_body').html(data);
                if (numData < <?php echo $numMsg+9; ?>) {
                    $('.msg_body').scrollTop(height);
                }
                else {
                    $('.msg_body').scrollTop(0);
                }
            },
            complete: function(data) {
                renew = setTimeout(function() {
                    updateMsg(to_from);
                }, 10000);
            }
        });
    }
});

</script>

<?php
    echo '<div class="msg_box">
    <div class="msg_head"><p id="from"><a href="profile.php?u='.$to_from.'" id="u_tofrom">'.$to_from.'</a></p>
        <div class="close"><i class="fa fa-times" aria-hidden="true" title="Close Chat"></i></div>
    </div>
    <div class="msg_body" id="body">';
    /*while ($row = mysqli_fetch_assoc($result)) {
        if ($row['u_from'] == $username) {
            echo '<div class="msg_a">'.$row['message'].'</div>';
        }
        else {
            echo '<div class="msg_b">'.$row['message'].'</div>';
            if ($row['opened'] == 0) {
                $id = $row['id'];
                mysqli_query($conn, "UPDATE messages SET opened='1' WHERE id='$id';");
            }
        }
    }
    echo '<div class="msg_insert"></div>*/
    echo '</div>
    <textarea class="msg_input" placeholder="Enter Message..."></textarea>
    <i class="fa fa-paper-plane fa-lg" aria-hidden="true" onclick="send(false)"></i>
</div>';
?>

        
        <!--<div class="msg_box">
            <div class="msg_head"><p id="from"><a href="profile.php?u=user1">User 1</a></p>
                <div class="close"><i class="fa fa-times" aria-hidden="true" title="Close Chat"></i></div>
            </div>
            <div class="msg_body" id="body1">
                <div class="msg_a">Yoo! Wanna trade these Yeezy?</div>
                <div class="msg_b">Yeah sure man.</div>
                <div class="msg_insert1"></div>
            </div>
            <textarea class="msg_input" id="1" placeholder="Enter Message..."></textarea>
            <i class="fa fa-paper-plane fa-lg" aria-hidden="true" onclick="send(1)"></i>
        </div>-->