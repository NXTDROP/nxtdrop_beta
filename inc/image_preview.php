<script type="text/javascript">
$(document).ready(function() {

    $('#preview_close').click(function() {
        $(".preview").fadeOut();
        $(".preview_main").fadeOut();
    });

    $('#preview_cancel').click(function() {
        $('.inputfiles').val('');
        $(".preview").fadeOut();
        $(".preview_main").fadeOut();
    });
});
</script>
<div class="preview">
            <div class="preview_close"></div>
            <div class="preview_main">
                <h2>Image Preview</h2>
                <div class="preview_content">
                    <img src="" id="preview_send"/>
                    <button name="cancel" id="preview_close">OK!</button>
                    <button name="cancel" id="preview_cancel">Cancel</button>
                </div>
            </div>
</div>