<script>
    $(document).ready(function(){
        $(".close").click(function(){
            $(".editListing_pop").fadeOut();
            $(".editListing_main").fadeOut(); 
        });
    });

    function saveChanges(offerID) {
        $('.btn-'+offerID).html('<i class="fas fa-circle-notch fa-spin"></i>');
        price = $('.input-'+offerID).val();
        //alert('New Price: ' + price + ', offerID: ' + offerID);
        $.ajax({
            url: 'inc/profile/updateOffer.php',
            type: 'POST',
            data: {offerID: offerID, price: price},
            success: function(response) {
                if(response == "DB") {
                    $('.btn-'+offerID).html('Error. Try later.');
                    setTimeout(() => {
                        $('.btn-'+offerID).html('Save New Price');
                    }, 5000);
                } else if(response == "not connected") {
                    $('.btn-'+offerID).html('Log in.');
                    setTimeout(() => {
                        $('.btn-'+offerID).html('Save New Price');
                    }, 5000);
                } else if(response == "unauthorized") {
                    $('.btn-'+offerID).html('Error. Try later.');
                    setTimeout(() => {
                        $('.btn-'+offerID).html('Save New Price');
                    }, 5000);
                } else if (response == "good") {
                    $('.btn-'+offerID).html('Saved.');
                    $('.input-'+offerID).attr('placeholder', price);
                    setTimeout(() => {
                        $('.btn-'+offerID).html('Save New Price');
                    }, 5000);
                } else {
                    $('.btn-'+offerID).html('Error. Try later.');
                    setTimeout(() => {
                        $('.btn-'+offerID).html('Save New Price');
                    }, 5000);
                }
            },
            error: function(response) {
                $('.btn-'+offerID).html('Error. Try later.');
            }
        });
    }

    function deleteListing(offerID) {
        $('.btn_delete-'+offerID).html('<i class="fas fa-circle-notch fa-spin"></i>');
        $.ajax({
            url: 'inc/profile/deleteOffer.php',
            type: 'POST',
            data: {offerID: offerID},
            success: function(response) {
                if(response == "DB") {
                    $('.btn_delete-'+offerID).html('Error. Try later.');
                    setTimeout(() => {
                        $('.btn_delete-'+offerID).html('Delete');
                    }, 5000);
                } else if(response == "not connected") {
                    $('.btn_delete-'+offerID).html('Log in.');
                    setTimeout(() => {
                        $('.btn_delete-'+offerID).html('Delete');
                    }, 5000);
                } else if(response == "unauthorized") {
                    $('.btn_delete-'+offerID).html('Error. Try later.');
                    setTimeout(() => {
                        $('.btn_delete-'+offerID).html('Delete');
                    }, 5000);
                } else if (response == "good") {
                    $('.listing-'+offerID).css('display', 'none');
                } else {
                    $('.btn_delete-'+offerID).html('Error. Try later.');
                    setTimeout(() => {
                        $('.btn_delete-'+offerID).html('Delete');
                    }, 5000);
                }
            },
            error: function(response) {
                $('.btn_delete-'+offerID).html('Error. Try later.');
                setTimeout(() => {
                    $('.btn_delete-'+offerID).html('Delete');
                }, 5000);
            }
        });
    }
</script>

<div class="editListing_pop">
    <div class="editListing_close close"></div>
    <div class="editListing_main">
        <h2>Edit "SHOENAME" Prices</h2>
        <div class="editListing_content">
            
        </div>
    </div>       
</div>