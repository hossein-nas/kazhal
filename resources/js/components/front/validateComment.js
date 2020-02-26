import validatejs from "validate.js";

$(document).ready(() => {
    let name = $("#cm-name");
    let content = $("#cm-content");
    let email = $("#cm-email");
    let submit = $("#submit");

    email.on("blur", validateEmail);
    name.on("keyup", validateUsername);
});

function validateEmail() {
    let email = $(this).val();
    let parentFormControl = $(this).parent(".form-control");

    if (email.length === 0) {
        parentFormControl.removeClass("error").removeClass("valid");
        return;
    }

    let regex = RegExp("^[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}$", "gi");
    if (!regex.test(email)) {
        parentFormControl.addClass("error");
    } else {
        parentFormControl.removeClass("error").addClass("valid");
    }
}

function validateUsername() {
    let name = $(this).val();
    let parentFormControl = $(this).parent(".form-control");
    let regex = RegExp("^[A-Zآ-ی._ 0-9]{3,}$", "gi");
    if (!regex.test(name)) {
        parentFormControl.addClass("error").removeClass("valid");
    } else {
        parentFormControl.removeClass("error").addClass("valid");
    }
}
