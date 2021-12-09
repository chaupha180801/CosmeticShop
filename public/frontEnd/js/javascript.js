$('.menu_icon').click(function() {
    $(this).toggleClass('fa-times');
    $('.list').toggleClass('navbar__toggle');
});

$(window).on('scroll load', function() {
    $('.menu_icon').removeClass('fa-times');

    $('.list').removeClass('navbar__toggle');
})

var menudo = document.querySelector('.navigation');
var trangthaimenudo = "move";

window.addEventListener('scroll', function() {

    if (window.pageYOffset > 120) {
        if (trangthaimenudo == 'move') {
            trangthaimenudo = "fix";
            menudo.classList.add('menuden');
        }

    } else if (window.pageYOffset <= 120) {
        if (trangthaimenudo == 'fix') {
            trangthaimenudo = "move";
            menudo.classList.remove('menuden');
        }

    }
})

search_icon_phone.addEventListener('click', () => {
    serch_phone.classList.toggle('kh');
    input_phone.focus();
})