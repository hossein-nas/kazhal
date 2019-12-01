$(document).ready(function(){
    manageNavbarAnchorLinks();
    managingGettingStarted();
    managingHashChange(); // this is triggered when page first load along with hash
    $(window).bind('hashchange', function(e){
        e.preventDefault();
        managingHashChange();
    })

});

function managingHashChange(){
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
}

function manageNavbarAnchorLinks(){
    $('nav a').click(function(){
        window.location.hash="#";
    })
}

function managingGettingStarted(){
    $('header p.bold').click(function(){
        window.location.hash = '#';
        window.location.hash = '#services-section';
    })
}