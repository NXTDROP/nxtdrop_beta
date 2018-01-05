<script type="text/javascript">
            function previewImage (input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#preview').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
            $(document).ready(function() {
                $(".inputfile").change(function() {
                    previewImage(this);
                    $('#preview').show();
                    $('#cancel_preview').show();
                });

                $('#cancel_preview').click(function() {
                    $('.inputfile').val('');
                    $('#preview').hide();
                    $('#cancel_preview').hide();
                });

                $('#submit_drop').click(function() {
                    var file_data = $('.inputfile').prop('files')[0];
                    var form_data = new FormData();                     // Create a form
                    form_data.append('file', file_data);           // append file to form
                    form_data.append('caption', $('#caption').val());
                    var scroll = $(window).scrollTop();
                    $.ajax({
                        url: "post/post.php",
                        type: 'POST',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,                         
                        success: function(data){
                            $('.inputfile').val('');
                            $('#caption').val('');
                            $('.post').fadeOut();
                            $('.post_main').fadeOut();
                            console.log(data);
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                });
            });
</script>
<div class="post">
            <div class="post_close close"></div>
            <div class="post_main">
                <h2>New Drop</h2>
                <div class="post_content">
                    <div method="POST" enctype="multipart/form-data" id="post" class="post-form">
                        <textarea name="caption" placeholder="Enter Description" id="caption"></textarea>
                        <input type="file" name="file" id="file" class="inputfile" accept="image/*" data-multiple-caption="{count} files selected" multiple />
                        <label for="file"><i class="fa fa-picture-o" aria-hidden="true"></i></label>
                        <button id="submit_drop">Drop</button>
                    </div>
                    <img id="preview"/>
                    <button name="cancel" id="cancel_preview">Cancel</button>
                </div>
            </div>
</div>