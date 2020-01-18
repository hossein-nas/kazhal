$(document).ready(() => {
    manageNavbarAnchorLinks();
    managingGettingStarted();
    managingHashChange(); // this is triggered when page first load along with hash
    $(window).bind("hashchange", (e) => {
        e.preventDefault();
        managingHashChange();
    });
});

function managingHashChange() {
    const { hash } = window.location;
    if (hash == "#home") {
        $("body, html").animate(
            {
                scrollTop: 0,
            },
            300
        );
    }
    if (hash == "#services-section") {
        const servicesTop = $("#services").offset().top;
        $("body, html").animate(
            {
                scrollTop: servicesTop - 30,
            },
            300
        );
    }
    if (hash == "#pricing-section") {
        const pricingTop = $("#pricing").offset().top;
        $("body, html").animate(
            {
                scrollTop: pricingTop - 70,
            },
            300
        );
    }
}

function manageNavbarAnchorLinks() {
    $("nav a").click(() => {
        window.location.hash = "#";
    });
}

function managingGettingStarted() {
    $("header p.bold").click(() => {
        window.location.hash = "#";
        window.location.hash = "#services-section";
    });
}
