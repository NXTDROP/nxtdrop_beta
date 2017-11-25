$(document).ready(function() {
    $("input[type='file']").change(function(){
        var file_data = $(".inputfile").prop('files')[0];
        var form_data = new FormData();                     // Create a form
        form_data.append('file', file_data);           // append file to form
        $.ajax({
            url: "inc/upload-profile-picture.php",
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            success: function(response){
                $('#myprofile').attr('src',response);
                $('.post-small-img').attr('src',response);
            }
        });
    });
});