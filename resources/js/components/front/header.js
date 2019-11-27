$(document).ready(function(){
    $(document).scroll(function(){
        var _header = $('.header');
        var top_of_element = $(".header").offset().top;
        var bottom_of_element = $(".header").offset().top + $(".header").outerHeight();
        var bottom_of_screen = $(window).scrollTop() + $(window).innerHeight();
        var top_of_screen = $(window).scrollTop();

        if( top_of_screen > bottom_of_element + 100 ){
            _header.addClass('topfixed');
            var fixed_elem = $('.fixed-header').length
            var _fixed_header = $(fixedmenuHTML());

            if( !fixed_elem ){
                $('body').append(_fixed_header)
                _fixed_header.animate({'top': '0'},200);
            }
        }
        else{
            _header.removeClass('topfixed');
            $('.fixed-header').animate({'top': '-100%'},100, function(){
                $('body .fixed-header').remove();
            });
        }

    })

})

function fixedmenuHTML(){
    return `
    <div class="fixed-header">
        <div class="hamburger"></div>
        <div class="search-btn"></div>
        <div class="logo"></div>
    </div>
    `.trim();
}