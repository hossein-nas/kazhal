var sidebar_status = 0;
var stickynavbar_status = 0;
var search_status = 0;
$(document).ready(function(){
    $(document).scroll(function(){
        var _header = $('.header');
        var top_of_element = $(".header").offset().top;
        var bottom_of_element = $(".header").offset().top + $(".header").outerHeight();
        var bottom_of_screen = $(window).scrollTop() + $(window).innerHeight();
        var top_of_screen = $(window).scrollTop();

        if( top_of_screen > bottom_of_element + 100 ){
            fadeInNavbar();
        }
        else{
            fadeOutNavbar();
        }

        if( top_of_screen > 1000 ){
            scrollTopFadeIn();
        }
        else{
            scrollTopFadeOut();
        }

    })

})

function hamburgerClickEvent(){
    $('.hamburger').click(function(){
        $('nav').addClass('active');
        sidebar_status = 1;
        setTimeout(function(){
            $('nav ul').addClass('show');
        },100)
    });
}


function fixedmenuHTML(){
    return `
    <div class="fixed-header">
        <div class="container">
            <div class="hamburger"></div>
            <div class="search-btn"></div>
            <div class="logo"></div>
        </div>
    </div>
    `.trim();
}

function fadeInNavbar(){
    $('.header').addClass('topfixed');
    var fixed_elem = $('.fixed-header').length
    var _fixed_header = $(fixedmenuHTML());

    if( !fixed_elem ){
        $('body').append(_fixed_header)

        // adding hamburger eventlistener
        hamburgerClickEvent();

        _fixed_header.animate({'top': '0'},200);
        stickynavbar_status = 1;
    }
}

function fadeOutNavbar(){
    if( sidebar_status != 1 ){
        $('.header').removeClass('topfixed');
        $('.fixed-header').animate({'top': '-100%'},100, function(){
            $('body .fixed-header').remove();
            stickynavbar_status = 0;
        });
    }
}

function scrollTopButton(){
    $('.scrollTop').click(function(){
        $('html, body').animate({
            scrollTop: 0
        }, 250 );
    });
}

function scrollTopFadeIn(){
    if ( ! $('.scrollTop').length ){
        var scrollTop = $('<div class="scrollTop"></div>');
        $('body').append(scrollTop);
        scrollTopButton();
    }
}

function scrollTopFadeOut(){
    $('.scrollTop').remove();
}