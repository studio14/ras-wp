window.onscroll = function() {stickTopMenu()};

var navbar = document.getElementById('#sub-menu');

var sticky = navbar.offsetTop;

function stickTopMenu() {
    if (window.pageYOffset >= sticky) {
        navbar.classList.add('sticky-sub-menu')
    } else {
        navbar.classList.remove('sticky-sub-menu');
    }
}