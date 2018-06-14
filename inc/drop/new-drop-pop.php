<script type="text/javascript">
            function previewImage (input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#post_preview').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
            $(document).ready(function() {
                $('#post_remove_button').attr('disabled', true);
                $('#upload_drop').attr('disabled', true);
                $(".inputfile").change(function() {
                    previewImage(this);
                    $('#post_remove_button').attr('disabled', false);
                }); 

                $('#post_remove_button').click(function() {
                    $('.inputfile').val('');
                    $('#post_preview').attr('src', 'img/no_image_available.jpeg');
                });

                $('#cancel_drop').click(function() {
                    $('.inputfile').val('');
                    $('#caption').val('');
                    $('#caption').css('border', '1px solid #e6e1e1');
                    $('#post_preview').attr('src', 'img/no_image_available.jpeg');
                    $('#product_trade').val('');
                    $('#product_price').val('');
                    $('.post').fadeOut(1000);
                    $('.post_main').fadeOut(1000);
                });

                $('#droptype').change(function() {
                    if ($(this).val() == 'S' || $(this).val() == 'L') {
                        $('#product-price').css('display', 'flex');
                        $('#product_trade').css('display', 'none');
                        if ($(this).val() == 'L') {
                            $('#product_price').attr('placeholder', 'Budget');
                        }
                    }
                    else if ($(this).val() == 'T') {
                        $('#product-price').css('display', 'none');
                        $('#product_trade').css('display', 'block');
                    }
                    else {
                        $('#product-price').css('display', 'none');
                        $('#product_trade').css('display', 'none');
                    }
                });

                $('#caption').keyup(function() {
                    var length =  $(this).val().length;
                    if (length >= 1) {
                        $('#upload_drop').attr('disabled', false);
                        $('#caption').css('border', '1px solid green');
                        $('#upload_drop').css('border', '1px solid #aa0000');
                        $('#upload_drop').css('background', '#aa0000');
                    }
                    else {
                        $('#caption').css('border', '1px solid red');
                        $('#upload_drop').attr('disabled', true);
                        $('#upload_drop').css('border', '1px solid #e6e1e1');
                        $('#upload_drop').css('background', '#e6e1e1');
                    }
                });

                $('#upload_drop').click(function() {
                    var upload = false;
                    if ($('#droptype').val() == 'Choose...') {
                        $('#droptype').css('border-color', 'red');
                    }
                    else if (!$('#caption').val().trim()) {
                        $('#caption').css('border-color', 'red');
                    }
                    else if  (($('#droptype').val() == 'S' || $('#droptype').val() == 'T' || $('#droptype').val() == 'ST') && $('.inputfile').val() == '') {
                        alert('An image is required when selling and/or trading.');
                    }
                    else if ($('#product_price').val() == '' && ($('#droptype').val() == 'S' || $('#droptype').val() == 'L')) {
                        $('#product_price').css('border-color', 'red');
                    }
                    else {
                        upload = true;
                    }

                    if (upload) {
                        $('#product_price').css('border-color', 'e6e1e1');
                        var file_data = $('.inputfile').prop('files')[0];
                        var form_data = new FormData();                     // Create a form
                        form_data.append('file', file_data);           // append file to form
                        form_data.append('caption', $('#caption').val());
                        form_data.append('type', $('#droptype').val());
                        form_data.append('product_price', $('#product_price').val());
                        var scroll = $(window).scrollTop();
                        $.ajax({
                            url: "post/post.php",
                            type: 'POST',
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: form_data,                         
                            success: function(data){
                                if (data == '') {
                                    $('.inputfile').val('');
                                    $('#caption').val('');
                                    $('.post').fadeOut(1000);
                                    $('.post_main').fadeOut(1000);
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
<div class="post">
            <div class="post_close close"></div>
            <div class="post_main">
                <div class="post_header">
                    <h2>New Drop</h2>
                </div>
                <div class="post_content">
                    <div class="post_image_section">
                        <div class="post_preview">
                            <img src="img/no_image_available.jpeg" id="post_preview">
                        </div>
                        <input type="file" name="file[]" id="file" class="inputfile" accept="image/*" data-multiple-caption="{count} files selected" multiple />
                        <label for="file"><button id="post_upload_button">Upload Image</button></label>
                        <button id="post_remove_button">Remove Image</button>
                        <p><b>*** Image Only Required When Selling or Trading.</b></p>
                    </div>
                        
                    <div class="post_info_section">
                        <div class="input-group mb-3">
                            <select class="custom-select" id="droptype" required>
                                <option selected>Choose...</option>
                                <option value="S">For Sale</option>
                                <option value="T">For Trade</option>
                                <!--<option value="ST">Sale/Trade</option>-->
                                <option value="L">Looking for an item</option>
                                <!--<option value="O">Other</option>-->
                            </select>
                            <div class="input-group-append">
                                <label class="input-group-text"     for="inputGroupSelect02">Drop Type</label>
                            </div>
                        </div>
                        <div class="input-group mb-3" id="product-price">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input id="product_price" type="text" class="form-control" aria-label="Amount (to the nearest dollar)" placeholder="Price" required>
                            <div class="input-group-append">
                                <span class="input-group-text">.00</span>
                            </div>
                        </div>
                        <textarea id="product_trade" placeholder="What are you trading for?" type="text"></textarea>
                        <textarea name="caption" placeholder="Enter Description ($$$, Condition, etc.)" id="caption"></textarea>
                    </div>

                    <button id="upload_drop">Upload Drop</button>
                    <button id="cancel_drop">Cancel</button>
                </div>
            </div>
</div>