
$('.accordion').click(function(){
    $(this).next('.year-content').slideToggle(300);
    $(this).toggleClass('close');
    $(this).children('svg').toggleClass('rotate');
});

$('.sub-menu-menu ul li').hover(function(event){
    event.preventDefault();
    console.log($(this));
    if ($(this).hasClass('current_page_parent') || $(this).hasClass('current_page_item') || $(this).hasClass('current_page_ancestor')) {
        return;
    }  
    else {
        const closest = $(this).children('ul');
        closest.stop().slideToggle(400)
        return;
    }
});

/** Our Team Hover */
$('.our-team .team-content').on('click', function(){
    $('.team_info').hide(400);
    const closest = $(this).children('.team_info');
    closest.stop().slideToggle(400);
    return;
});

/** Owl carousel */
$(document).ready(function(){
  $('.owl-carousel').owlCarousel(
      {
        width:'100vw',
        items:1,
        dots: true,
        autoplay: true,
        autoPlaySpeed: 7000,
        autoPlayTimeout: 7000,
        loop: true,
        autoplayHoverPause: true,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
      }
  );

    $('.squaredOne input').click(function(){
        var newsletters = [];
        $.each($('input[name=\'INTERESTS[88bff24642][]\']:checked'), function(){         
            newsletters.push($(this).attr('data-content'));
            console.log($(this).closest('span'));
        });
        $('#newsletter_values').val(newsletters.join(', '));
        if (newsletters.length == 0) {
            $('#newsletter_values').attr('value', '');
            $('#newsletter_values').attr('placeholder', 'Select Newsletter *');
        }
    });

    $('.multiselect > .selectBox').on('click', function() {
        if ($(this).hasClass('active')) {
        $(this).delay(200).removeClass('active');
        $(this)
            .siblings('#checkboxes')
            .slideUp(200);
        } else {
        $(this)
            .find('i')
            .removeClass('fa-plus')
            .addClass('fa-minus');
        $(this).delay(200).addClass('active');
        $('#checkboxes').slideUp(200);
        $(this)
            .siblings('#checkboxes')
            .slideDown(200);
        }
    });

    //disable the mobile menu from clicking
    $('.static-mobile .menu-item-has-children').closest('a').attr('href', '#');

    /** Toggle menu */
    $('.hamburger').on('click', function() {
        $('#mySidenav').toggleClass('full-width');
        $('.mobile-menu-diff').toggleClass('fixed');
        $('.sub-menu-detail-list').toggleClass('removeZIndex');
        $('.mobile_menu_logo').toggle();
        $('.desktop_menu_logo').toggle();
        $(this).toggleClass('is-active')
        return;
    });

    //for the submenu 
    $('.scroll-mobile-menu ul li a').each(function() {
        var $this = $(this);       
        var _href = $this.attr('href'); 
        $this.attr('href', _href + '#submenu');
    });

    //navigate to top of menu 
    if (window.location.href.indexOf('#submenu') > -1) {
        const windowHeight = window.innerHeight/2;
         window.scrollBy(0,windowHeight);
    }

    //show the sub menu items
    /** Our Team Hover */
    $('.menu-mobile-menu-container ul .menu-item-has-children').on('click', function(){
        $('.sub-menu').hide(400);
        $(this).children('.sub-menu').stop().slideToggle('slow');
        return;
    });

});

$(document).click(function(e) {
    if (!$('.multiselect').is(e.target) && !$('.multiselect').has(e.target).length) {
        const element = $('.multiselect > .selectBox');
        element.removeClass('active');
        element
            .siblings('#checkboxes')
            .slideUp(200);
        $('.set > a i')
            .removeClass('fa-minus')
            .addClass('fa-plus');
    }
});

window.onscroll = function() {stickTopMenu()};

var navbar = document.querySelector('#sub-menu');

var sticky = navbar.offsetTop;

function stickTopMenu() {
    if (window.pageYOffset >= sticky) {
        navbar.classList.add('sticky-menu')
    } else {
        navbar.classList.remove('sticky-menu');
    }
}