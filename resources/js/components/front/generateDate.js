import PersianDate from "persian-date";

$(document).ready(() => {
    let elem = $(".gen-date");

    elem.each(function(index) {
        let date = $(this).data("date");
        let newDate = new PersianDate()
            .unix(date)
            .format("dddd D MMMM YYYY - HH:m");
        $(this).html(newDate);
    });
});
