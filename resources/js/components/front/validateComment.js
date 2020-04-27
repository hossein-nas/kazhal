import validation from "../../modules/validation";
import axios from "axios";

$(document).ready(() => {
    let name = validation("#cm-name", {
        required: true,
        name: "نام کاربری",
        min: 3,
        max: 50,
    });

    let content = validation("#cm-content", {
        required: true,
        name: "متن دیدگاه",
        min: 10,
        max: 300,
    });

    let email = validation("#cm-email", {
        name: "ایمیل",
        email: true,
    });

    submit(name, email, content);
});

function submit() {
    let args = arguments;
    $("#submit").bind("click", (e) => {
        e.preventDefault();
        if (checkInputValidity(getInputs(args))) {
            sendAjax(args);
        }
    });
}

function checkInputValidity(inputs) {
    let res = true;
    inputs.map((elem, ind) => {
        if (elem.validate() == false) {
            res = false;
        }
    });
    return res;
}

function getInputs(args) {
    let inputs = [];
    Object.keys(args).map((key) => {
        inputs.push(args[key]);
    });
    return inputs;
}

function sendAjax(fields) {
    let inputs = getInputValues(fields);
    axios({
        url: "/hey",
        method: "POST",
        data: inputs,
    });
}

function getInputValues(fields) {
    fields = getInputs(fields);
    let res = {};
    fields.map((elem, ind) => {
        res[elem.state.el.attr("name")] = elem.state.el.val();
    });

    // this is for adding hidden inputs

    res["parent_id"] = $(".form .parent_id").val();
    return res;
}
