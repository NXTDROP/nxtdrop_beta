<script>
    var user_id;
    var username;
    var post_id;
    var user_rating;

    function sold(pid, type) {
        post_id = pid;
        post_type = type;
        if (post_type == 0) {
            $("#merchant_header").html('SOLD TO (Click to select):');
            $("#rate_buyer").html('RATE SELLER');
        }
        else {
            $("#merchant_header").html('BOUGHT FROM (Click to select):');
        }

        $.ajax({
            url: 'inc/transaction/users_report_display.php',
            type: 'GET',
            success: function(data) {
                $('.users_dm').html(data);
            }
        });
        
        $(".transaction_pop").fadeIn();
        $(".transaction_main").show();
    }

    function s_rating(star_num) {
        user_rating = star_num;
        for (var i = 1; i <= 5; i++) {
            if (star_num == 3) {
                alert('NO 3s ALLOWED. PLEASE RATE AGAIN.');
                return;
            }
            else if (i <= star_num) {
                $('#star-'+i).attr('class', 'fas fa-star fa-2x');
                $('#star-'+i).css('color', '#aa0000');
            }
            else {
                $('#star-'+i).attr('class', 'far fa-star fa-2x');
                $('#star-'+i).css('color', '#000');
            }
        }
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
            form_data.append('user_comment', $('#user_comment').val());
            form_data.append('target_username', username);
            form_data.append('post_id', post_id);
            form_data.append('user_rating', user_rating);
            form_data.append('post_type', post_type)
            if (user_rating != 1 || user_rating != 2 || user_rating != 3 || user_rating != 4 || user_rating != 5) {
                    alert('RATE BUYER PLEASE.');
            }
            else {
                alert(user_rating);
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
                            $('#user_comment').val('');
                            $('#send_transaction_report').attr('disabled', true);
                            $('#send_transaction_report').css('background', '#e6e1e1');
                            for (var i = 1; i <= 5; i++) {
                                $('#star-'+i).attr('class', 'far fa-star fa-2x');
                                $('#star-'+i).css('color', '#000');
                            }
                            $(".transaction_pop").fadeOut(1000);
                            $(".transaction_main").fadeOut(1000);
                        }
                        else {
                            alert(data);
                        }
                    }
                });
            }
        });

        $(".close").click(function(){
            $(".transaction_pop").fadeOut();
            $(".transaction_main").fadeOut();
            $('#send_transaction_report').attr('disabled', true);
            $('#send_transaction_report').css('background', '#e6e1e1');
            $('#pricing').val('');
            $('#user_comment').val('');
            for (var i = 1; i <= 5; i++) {
                $('#star-'+i).attr('class', 'far fa-star fa-2x');
                $('#star-'+i).css('color', '#000');
            }
        });

        $('#cancel_transaction_report').click(function() {
            $(".transaction_pop").fadeOut();
            $(".transaction_main").fadeOut();
            $('#send_transaction_report').attr('disabled', true);
            $('#send_transaction_report').css('background', '#e6e1e1');
            $('#pricing').val('');
            $('#user_comment').val('');
            for (var i = 1; i <= 5; i++) {
                $('#star-'+i).attr('class', 'far fa-star fa-2x');
                $('#star-'+i).css('color', '#000');
            }
        });
    });
</script>

<div class="transaction_pop">
    <div class="transaction_close close"></div>
    <div class="transaction_main">
        <h2>TRANSACTION REPORT</h2>
        <div class="transaction_content">
            <div class="transaction_merchant">
                <p id="merchant_header"></p>
                <div class="users_dm">
                </div>
            </div>

            <div class="transaction_info">
                <p id="transaction_info_header">TRANSACTION INFORMATION:</p>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">$</span>
                    </div>
                    <input type="number" class="form-control" placeholder="Price (OPTIONAL)" id="pricing" aria-label="Price" aria-describedby="basic-addon1">
                </div>
                <p id="rate_buyer">RATE BUYER</p>
                <p id="nothree">We're enforcing a 'No 3s Allowed Policy' because we believe that a 'neutral' feedback can be misleading.</p>
                <ul id="rating_stars">
                    <li><i class="far fa-star fa-2x" aria-hidden="true" id="star-1" onclick="s_rating(1)"></i></li>
                    <li><i class="far fa-star fa-2x" aria-hidden="true" id="star-2" onclick="s_rating(2)"></i></li>
                    <li><i class="far fa-star fa-2x" aria-hidden="true" id="star-3" onclick="s_rating(3)"></i></li>
                    <li><i class="far fa-star fa-2x" aria-hidden="true" id="star-4" onclick="s_rating(4)"></i></li>
                    <li><i class="far fa-star fa-2x" aria-hidden="true" id="star-5" onclick="s_rating(5)"></i></li>
                </ul>
                <textarea name="comment" id="user_comment" placeholder="Add comment... (OPTIONAL)"></textarea>
            </div>

            <button id="send_transaction_report">DONE</button>
            <button id="cancel_transaction_report">CANCEL</button>
        </div>
    </div>       
</div>