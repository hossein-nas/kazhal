import validation from "../../modules/validation";
import addReply from "../../modules/addReplyBtn";
import axios from "axios";

$(document).ready(() => {
    /**
     * Managing AddReply Button functionality
     */
    addReply();

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
        url: "/comments/create",
        method: "POST",
        data: inputs,
    })
        .then(({ data }) => {
            clearInputs(fields);
            addSuccessMessage(data.text);
        })
        .catch((err) => {
            alert("error");
            // showErrorMessages();
        });
}

function clearInputs(inputs) {
    inputs = getInputs(inputs);
    inputs.map((elem, ind) => {
        elem.state.el.val("");
    });
}

function addSuccessMessage(message) {
    let _form = $(".form");
    let elem = $(
        `
        <div class="success-message">
            <i class="material-icons">check_circle</i>
            ${message}
        </div>
    `.trim()
    );
    elem.insertBefore(_form);
    setTimeout(() => {
        elem.remove();
    }, 3500);
}

function getInputValues(fields) {
    fields = getInputs(fields);
    let res = {};
    fields.map((elem, ind) => {
        res[elem.state.el.attr("name")] = elem.state.el.val();
    });

    // this is for adding hidden inputs

    res["parent_id"] = $(".form .parent_id").val();
    res["post_id"] = $(".form .post_id").val();
    return res;
}
