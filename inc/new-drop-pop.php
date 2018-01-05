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
            });
        </script>
<div class="post">
            <div class="post_close close"></div>
            <div class="post_main">
                <h2>New Drop</h2>
                <div class="post_content">
                    <form action="post/post.php" method="POST" enctype="multipart/form-data" id="post" class="post-form">
                        <textarea name="caption" placeholder="Enter Description" id="caption"></textarea>
                        <input type="file" name="file" id="file" class="inputfile" accept="image/*" data-multiple-caption="{count} files selected" multiple />
                        <label for="file"><i class="fa fa-picture-o" aria-hidden="true"></i></label>
                        <button type="submit" name="submit" id="submit">Drop</button>
                    </form>
                    <img id="preview"/>
                    <button name="cancel" id="cancel_preview">Cancel</button>
                </div>
            </div>
</div>