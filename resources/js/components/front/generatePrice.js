var persianJs = require("persianjs");
$(document).ready(() => {
    let elem = $(".gen-price");
    elem.each(function(index) {
        let price = $(this).data("price");
        price = persianJs(price).englishNumber()._str;
        price = price
            .split("")
            .reverse()
            .join("");
        let newPrice = "";
        let priceLen = price.length;
        for (let $i = 0; $i < priceLen; $i++) {
            newPrice += price[$i];
            if (($i + 1) % 3 === 0 && $i + 1 !== priceLen) {
                newPrice += "٫";
            }
        }
        price =
            newPrice
                .split("")
                .reverse()
                .join("") + "<small> تومان</small>";

        $(this).html(price);
    });
});
