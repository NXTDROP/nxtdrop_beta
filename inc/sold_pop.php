<script>
    var user_id;
    var username;
    function sold(pid, type) {
        post_id = pid;
        post_type = type;
        if (type == 0) {
            $("#merchant_header").html('Sold To (Click to select):');
        }
        else {
            $("#merchant_header").html('Bought From (Click to select):');
        }
        $('.users_info').css('background', '#fff');
        $(".transaction_pop").fadeIn();
        $(".transaction_main").show();
    }

    function select(u) {
        username = u;
        $('#send_transaction_report').attr('disabled', false);
        $('#send_transaction_report').css('background', '#aa0000');
        $('#user-'+u).css('background', '#aa0000');
    }

    $(document).ready(function(){
        $('#send_transaction_report').attr('disabled', true);

        $('#send_transaction_report').click(function() {
            var form_data = new FormData(); // Create a form
            form_data.append('price', $('#pricing').val());
            form_data.append('comment', $('#comment').val());
            form_data.append('target_id', username);
            $.ajax({
                url: 'inc/send_transaction_report.php',
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(data){
                    if (data == '') {
                        $('#pricing').val('');
                        $('#comment').val('');
                        $('#send_transaction_report').attr('disabled', true);
                        $('#send_transaction_report').css('background', '#e6e1e1');
                        $('.post').fadeOut(1000);
                        $('.post_main').fadeOut(1000);
                    }
                    else {
                        alert(data);
                    }
                }
            });
        });

        $(".close").click(function(){
            $(".transaction_pop").fadeOut();
            $(".transaction_main").fadeOut();
            $('#send_transaction_report').attr('disabled', true);
            $('#send_transaction_report').css('background', '#e6e1e1');
            $('#pricing').val('');
            $('#comment').val('');
        });

        $('#cancel_transaction_report').click(function() {
            $(".transaction_pop").fadeOut();
            $(".transaction_main").fadeOut();
            $('#send_transaction_report').attr('disabled', true);
            $('#send_transaction_report').css('background', '#e6e1e1');
            $('#pricing').val('');
            $('#comment').val('');
        });
    });
</script>

<div class="transaction_pop">
    <div class="transaction_close close"></div>
    <div class="transaction_main">
        <h2>Transaction Report</h2>
        <div class="transaction_content">
            <div class="transaction_merchant">
                <p id="merchant_header"></p>
                <div class="users_dm">
                    <div class="users_info" id="user-nxtdrop" onclick="select('nxtdrop')">
                        <img src="https://nxtdrop.com/img/nxtdroplogo.png" alt="User" id="user_info_img">
                        <span>nxtdrop</span>
                    </div>
                </div>
            </div>

            <div class="transaction_info">
                <p id="transaction_info_header">Transaction Information:</p>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">$</span>
                    </div>
                    <input type="number" class="form-control" placeholder="Price (OPTIONAL)" id="pricing" aria-label="Price" aria-describedby="basic-addon1">
                </div>
                <textarea name="comment" id="comment" placeholder="Add comment... (OPTIONAL)"></textarea>
            </div>

            <button id="send_transaction_report">Done</button>
            <button id="cancel_transaction_report">Cancel</button>
        </div>
    </div>       
</div>