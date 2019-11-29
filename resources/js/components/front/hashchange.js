$(document).ready(function(){
    $(window).bind('hashchange', function(e){
        e.preventDefault();
        var hash = window.location.hash
        if( hash == "#home"){
            $('body, html').animate({
                'scrollTop': 0
            }, 300)
        }
        if ( hash == "#services-section" ){
            var services_top = $('#services').offset().top;
            $('body, html').animate({
                'scrollTop': services_top - 30
            },300)
        }
        if ( hash == "#pricing-section" ){
            var pricing_top = $('#pricing').offset().top;
            $('body, html').animate({
                'scrollTop': pricing_top - 70
            },300)
        }
    })

});