let sidebar_status = 0;
window.stickynavbar_status = 0;

$(document).ready(() => {
    headerButtonEvents();
    $(document).scroll(() => {
        const _header = $(".header");
        const top_of_element = $(".header").offset().top;
        const bottom_of_element =
            $(".header").offset().top + $(".header").outerHeight();
        const bottom_of_screen =
            $(window).scrollTop() + $(window).innerHeight();
        const top_of_screen = $(window).scrollTop();

        if (top_of_screen > bottom_of_element + 100) {
            fadeInNavbar();
        } else {
            fadeOutNavbar();
        }

        if (top_of_screen > 1000) {
            scrollTopFadeIn();
        } else {
            scrollTopFadeOut();
        }
    });
});

function headerButtonEvents() {
    $(".hamberger").click(() => {
        const _nav = $("nav");
        if (_nav.hasClass("active")) {
            navbarFadOut();
        } else {
            navbarFadeIn();
        }
    });
}

function hamburgerClickEvent() {
    $(".hamburger").click(() => {
        const _nav = $("nav");
        if (_nav.hasClass("active")) {
            navbarFadOut();
        } else {
            navbarFadeIn();
        }
    });
    $("nav").click(() => {
        navbarFadOut();
    });
}

function navbarFadOut() {
    $("nav ul").removeClass("show");
    sidebar_status = 0;
    setTimeout(() => {
        $("nav").removeClass("active");
    }, 200);
}
function navbarFadeIn() {
    $("nav").addClass("active");
    sidebar_status = 1;
    setTimeout(() => {
        $("nav ul").addClass("show");
    }, 100);
}

function fixedmenuHTML() {
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

function fadeInNavbar() {
    $(".header").addClass("topfixed");
    const fixed_elem = $(".fixed-header").length;
    const _fixed_header = $(fixedmenuHTML());

    if (!fixed_elem) {
        $("body").append(_fixed_header);

        // adding hamburger eventlistener
        hamburgerClickEvent();

        _fixed_header.animate({ top: "0" }, 200);
        stickynavbar_status = 1;
    }
}

function fadeOutNavbar() {
    if (sidebar_status != 1) {
        $(".header").removeClass("topfixed");
        $(".fixed-header").animate({ top: "-100%" }, 100, () => {
            $("body .fixed-header").remove();
            stickynavbar_status = 0;
        });
    }
}

function scrollTopButton() {
    $(".scrollTop").click(() => {
        $("html, body").animate(
            {
                scrollTop: 0,
            },
            250
        );
    });
}

function scrollTopFadeIn() {
    if (!$(".scrollTop").length) {
        const scrollTop = $('<div class="scrollTop"></div>');
        $("body").append(scrollTop);
        scrollTopButton();
    }
}

function scrollTopFadeOut() {
    $(".scrollTop").remove();
}
