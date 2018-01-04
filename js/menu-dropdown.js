$(document).ready(function() {
    $('.profile-img-profile').click(function() {
        if($('.profile-picture').css('display') == 'none') {
            $('.profile-picture').show();
        }
        else {
            $('.profile-picture').hide();
        }
    });
});

function more() {
    document.getElementById("myDropdown").classList.toggle("show");
}

function profile_pop() {
    $('.profile-picture').show();
}

window.onclick = function(event) {
    if (!event.target.matches('#dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}