$(document).ready(function() {
    $('.header').animate({
        opacity: '1'
    }, 250);

    $('#buy').animate({
        opacity: '1'
    }, 500);

    $('#authentication').animate({
        opacity: '1'
    }, 1000);

    $('#delivery').animate({
        opacity: '1'
    }, 1500);

    $('h3').animate({
        opacity: '1'
    }, 2000);

    $('#text-over-btn').animate({
        opacity: '1'
    }, 2500);

    $('.cta').animate({
        opacity: '1'
    }, 3000);

    $('#text-under-btn').animate({
        opacity: '1'
    }, 3000, function() {
        $('.laptop').animate({
            opacity: '1',
            top: '66%'
        }, 100);

        $('.text').animate({
            opacity: '1',
        }, 100);
    });
});