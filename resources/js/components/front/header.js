$(document).ready(function(){
    $(document).scroll(function(){
        var _header = $('.header');
        var top_of_element = $(".header").offset().top;
        var bottom_of_element = $(".header").offset().top + $(".header").outerHeight();
        var bottom_of_screen = $(window).scrollTop() + $(window).innerHeight();
        var top_of_screen = $(window).scrollTop();

        if( top_of_screen + 50 > bottom_of_element ){
            _header.addClass('topfixed');
            var fixed_elem = $('.fixed-header').length
            var _fixed_header = $(fixedmenuHTML());
            if( !fixed_elem ){
                $('body').append(_fixed_header)
            }
        }
        else{
            _header.removeClass('topfixed');
            $('body .fixed-header').remove();
        }

    })

})

function fixedmenuHTML(){
    return `
    <div class="fixed-header">
        <div class="hamburger"></div>
        <div class="search"></div>
        <div class="logo"></div>
    </div>
    `.trim();
}