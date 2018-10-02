<script type="text/javascript">
    $(document).ready(function() {
        $('#search').keyup(function() {
            $('.users_results').html('<div class="users_results"><p>LOADING...</p></div>');
            var search = $(this).val();
            /*$.ajax({
                url: 'inc/search_results.php',
                type: 'GET',
                data: {search: search},
                dataType: 'text',
                success: function(results) {
                    $('.users_results').html(results);
                }
            });*/

            $.ajax({
                url: 'inc/search_users.php',
                type: 'GET',
                data: {search: search},
                dataType: 'text',
                success: function(data) {
                    $('#posts-container-search').html(data);
                }
            });
        });
    });

    function to_item(model) {
        window.location.href = 'sneakers/' + model;
    }
</script>

<div class="search_post">
    <div class="search_close close"></div>
    <div class="search_main">
        <div class="search_header">
            <h2>SEARCH RESULTS</h2>
        </div>
        <div class="search_content">
            <!--<div class="users_results">

            </div>-->

            <div id="posts-container-search">

            </div>
        </div>
    </div>
</div>