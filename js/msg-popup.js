$(document).ready(function(){
    $(".message_button").click(function(){
        $(".new_msg_pop").fadeIn();
        $(".new_msg_main").show();
    });

    $(".close").click(function(){
        $(".new_msg_pop").fadeOut();
        $(".new_msg_main").fadeOut();
    });
});