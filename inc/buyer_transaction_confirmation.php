<script>
    var buyer_rating;
    var post_id;
    var seller_id;
    var buyer_id;

    function confirmation(seller_id, buyer_id, pid) {
        post_id = pid;
        seller_id = seller_id;
        buyer_id = buyer_id;
        var data = new FormData();
        data.append('pid', post_id);
        data.append('seller_id', seller_id);
        data.append('buyer_id', buyer_id);
        $.ajax({
            url: 'inc/transaction/report_info_display.php',
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            success: function(data) {
                $('.seller_report_info').html(data);
            }
        });
        $(".transaction_review_pop").fadeIn();
        $(".transaction_review_main").show();
    }

    function b_rating(star_num) {
        buyer_rating = star_num;
        for (var i = 1; i <= 5; i++) {
            if (star_num == 3) {
                alert('NO 3s ALLOWED. PLEASE RATE AGAIN.');
                return;
            }
            else if (i <= star_num) {
                $('#star-buyer-'+i).attr('class', 'fa fa-star fa-2x');
                $('#star-buyer-'+i).css('color', '#aa0000');
            }
            else {
                $('#star-buyer-'+i).attr('class', 'fa fa-star-o fa-2x');
                $('#star-buyer-'+i).css('color', '#000');
            }
        }
    }

    $(document).ready(function() {
        $('#buyer_comment').focus(function() {
            $('#buyer_comment').css('border', '1px solid #aa0000');
        });

        $('#buyer_comment').focusout(function() {
            $('#buyer_comment').css('border', '1px solid #e1e6e6');
        });

        $('.close').click(function() {
            $('#buyer_comment').val();
            for (var i = 1; i <= 5; i++) {
                $('#star-buyer-'+i).attr('class', 'fa fa-star-o fa-2x');
                $('#star-buyer-'+i).css('color', '#000');
            }
            $('.transaction_review_pop').fadeOut(1000);
            $('.transaction_review_main').fadeOut(1000);
        });

        $('#confirm_review').click(function() {
            var form_data = new FormData(); // Create a form
            form_data.append('buyer_rating', buyer_rating);
            form_data.append('post_id', post_id);
            form_data.append('buyer_comment', $('#buyer_comment').val());
            form_data.append('seller_username', $('#seller_username').val());
            if (seller_rating != 1 || seller_rating != 2 || seller_rating != 3 || seller_rating != 4 || seller_rating != 5) {
                alert('RATE SELLER PLEASE.');
            }
            else {
                $.ajax({
                    url: 'inc/send_transaction_review.php',
                    type: 'POST',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function(data){
                        if (data == '') {
                            $('#comment').val('');
                            for (var i = 1; i <= 5; i++) {
                                $('#star-buyer-'+i).attr('class', 'fa fa-star-o fa-2x');
                                $('#star-buyer-'+i).css('color', '#000');
                            }
                            $('.transaction_review_pop').fadeOut(1000);
                            $('.transaction_review_main').fadeOut(1000);
                        }
                        else {
                            alert(data);
                        }
                    }
                });
            }
        });
    });
</script>

<div class="transaction_review_pop">
    <div class="transaction_review_close close"></div>
    <div class="transaction_review_main">
        <h2>TRANSACTION REVIEW</h2>
        <div class="transaction_review_content">
            <div class="seller_report_info">
            </div>
            <p id="rate_seller">RATE SELLER</p>
            <p id="nothree">We're enforcing a 'No 3s Allowed Policy' because we believe that a 'neutral' feedback can be misleading.</p>
            <ul id="rating_stars">
                <li><i class="fa fa-star-o fa-2x" aria-hidden="true" id="star-buyer-1" onclick="b_rating(1)"></i></li>
                <li><i class="fa fa-star-o fa-2x" aria-hidden="true" id="star-buyer-2" onclick="b_rating(2)"></i></li>
                <li><i class="fa fa-star-o fa-2x" aria-hidden="true" id="star-buyer-3" onclick="b_rating(3)"></i></li>
                <li><i class="fa fa-star-o fa-2x" aria-hidden="true" id="star-buyer-4" onclick="b_rating(4)"></i></li>
                <li><i class="fa fa-star-o fa-2x" aria-hidden="true" id="star-buyer-5" onclick="b_rating(5)"></i></li>
            </ul>
            <textarea name="comment" id="buyer_comment" placeholder="Add Comment... (Optional)"></textarea>
            <button id="confirm_review">CONFIRM</button>
        </div>
    </div>       
</div>