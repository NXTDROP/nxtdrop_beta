<script>
    var buyer_rating;
    var post_id;
    var seller_id;
    var buyer_id;

    function confirmation(seller_id, buyer_id, pid) {
        post_id = pid;
        seller_id = seller_id;
        buyer_id = buyer_id;
        $(".transaction_review_pop").fadeIn();
        $(".transaction_review_main").show();
    }

    function star_selected(star_num) {
        buyer_rating = star_num;
        for (var i = 1; i <= 5; i++) {
            if (star_num == 3) {
                alert('NO 3s ALLOWED. PLEASE RATE AGAIN.');
                return;
            }
            else if (i <= star_num) {
                $('#star-'+i).attr('class', 'fa fa-star fa-2x');
                $('#star-'+i).css('color', '#aa0000');
            }
            else {
                $('#star-'+i).attr('class', 'fa fa-star-o fa-2x');
                $('#star-'+i).css('color', '#000');
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
                $('#star-'+i).attr('class', 'fa fa-star-o fa-2x');
                $('#star-'+i).css('color', '#000');
            }
            $('.transaction_review_pop').fadeOut(1000);
            $('.transaction_review_main').fadeOut(1000);
        });

        $('#confirm_review').click(function() {
            var form_data = new FormData(); // Create a form
            post_id = 1000034;
            form_data.append('buyer_rating', buyer_rating);
            form_data.append('post_id', post_id);
            form_data.append('buyer_comment', $('#comment').val());
            form_data.append('seller_username', $('#seller_username').val());
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
                            $('#star-'+i).attr('class', 'fa fa-star-o fa-2x');
                            $('#star-'+i).css('color', '#000');
                        }
                        $('.transaction_review_pop').fadeOut(1000);
                        $('.transaction_review_main').fadeOut(1000);
                    }
                    else {
                        alert(data);
                    }
                }
            });
        });
    });
</script>

<div class="transaction_review_pop">
    <div class="transaction_review_close close"></div>
    <div class="transaction_review_main">
        <h2>TRANSACTION REVIEW</h2>
        <div class="transaction_review_content">
            <p id="seller_username"><b>SELLER:</b> <span id="seller_username">momarcissex</span></p>
            <p><b>PRODUCT</b></p>
            <img id="product_image" src="https://nxtdrop.com/img/nxtdroplogo.png" alt="">
            <p id="product_price"><b>PRICE:</b> $120</p>
            <p id="transaction_comment"><b>COMMENT:</b> Air Jordan 4s Motorsport</p>
            <p><b>SELLER RATED YOU:</b> 2 <span><i class="fa fa-star" aria-hidden="true"></i></span></p>
            <p id="rate_seller">RATE SELLER</p>
            <p id="nothree">We're enforcing a 'No 3s Allowed Policy' because we believe that a 'neutral' feedback can be misleading.</p>
            <ul id="rating_stars">
                <li><i class="fa fa-star-o fa-2x" aria-hidden="true" id="star-1" onclick="star_selected(1)"></i></li>
                <li><i class="fa fa-star-o fa-2x" aria-hidden="true" id="star-2" onclick="star_selected(2)"></i></li>
                <li><i class="fa fa-star-o fa-2x" aria-hidden="true" id="star-3" onclick="star_selected(3)"></i></li>
                <li><i class="fa fa-star-o fa-2x" aria-hidden="true" id="star-4" onclick="star_selected(4)"></i></li>
                <li><i class="fa fa-star-o fa-2x" aria-hidden="true" id="star-5" onclick="star_selected(5)"></i></li>
            </ul>
            <textarea name="comment" id="buyer_comment" placeholder="Add Comment... (Optional)"></textarea>
            <button id="confirm_review">CONFIRM</button>
        </div>
    </div>       
</div>