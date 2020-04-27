import validatejs from "validate.js";

export default function validation(elem, props) {
    let state = {
        el: undefined,
        value: "",
        length: 0,
        counter: false,
        max: null,
        min: null,
        pattern: null,
        valid: undefined,
        errors: {},
        error_count: 0,
    };

    (() => {
        getElem(elem);
        bindValue();
        mergeProps(props);
        updateErrorState();
        bindValidateEvent();
    })();

    function bindValidateEvent() {
        state.el.bind("keydown blur", () => {
            validateFields();
        });
    }

    function validateFields() {
        if (state.required === true) {
            makeRequired();
        }

        if (state.min !== null) {
            setMinimum();
        }

        if (state.max !== null) {
            setMaximum();
        }

        if (state.email === true) {
            validateEmail();
        }
    }

    function getElem(elem) {
        state.el = $(elem).first();
    }

    function bindValue() {
        state.el.bind("keyup", (el) => {
            state.value = el.target.value;
            state.length = el.target.value.length;
        });
    }

    function mergeProps(props) {
        state = Object.assign({}, state, props);
    }

    (function() {
        state.el.on("click", function() {
            console.log(state);
        });
    })();

    function makeRequired() {
        if (isEmpty() === true) {
            addError("required", [state.name, "را باید وارد کنید."].join(" "));
        } else {
            removeError("required");
        }
    }

    function isEmpty() {
        return !state.length;
    }

    function updateErrorState() {
        let errorCount = Object.keys(state.errors).length;
        state.error_count = errorCount;

        if (errorCount > 0) {
            state.valid = false;
        }

        if (errorCount === 0) {
            state.valid = true;
        }

        updateErrorBox();
    }

    function getErrorBox() {
        let formControll = state.el.parent();
        let ErrorBox;

        if (formControll.find(".messages").length === 0) {
            ErrorBox = $(`
	    		<div class="messages">
					<ul>
					</ul>
				</div>
			`).appendTo(formControll);
        } else ErrorBox = formControll.find(".messages");

        ErrorBox.find("ul").html("");
        return ErrorBox;
    }

    function updateErrorBox() {
        let formControll = state.el.parent();
        let ErrorBox = getErrorBox();

        if (state.valid === false) formControll.addClass("error");
        else formControll.removeClass("error");

        Object.keys(state.errors).map((key, ind) => {
            let errorText = state.errors[key];
            let newElem = $("<li>")
                .addClass("error")
                .html(errorText)
                .prepend("<i class='material-icons'>error</i> ");
            ErrorBox.find("ul").append(newElem);
        });
    }

    function addError(error, desc) {
        state.errors[error] = desc;
        updateErrorState();
    }

    function removeError(error) {
        delete state.errors[error];
        updateErrorState();
    }

    function setMinimum() {
        if (state.length < state.min)
            addError(
                "min",
                [
                    state.name,
                    "حداقل باید",
                    state.min,
                    " کاراکتر وارد کنید.",
                ].join(" ")
            );
        else removeError("min");
    }

    function setMaximum() {
        if (state.length > state.max)
            addError(
                "min",
                [
                    state.name,
                    "حداکثر باید",
                    state.max,
                    " کاراکتر وارد کنید.",
                ].join(" ")
            );
        else removeError("max");
    }

    function validateEmail() {
        let contstrains = {
            email: {
                email: true,
            },
        };

        let res = validatejs({ email: state.value }, contstrains, {
            format: "flat",
        });

        if (res !== undefined && state.length > 0) {
            addError(
                "email",
                [state.name, "به درستی وارد نشده است."].join(" ")
            );
        } else removeError("email");
    }

    function validate() {
        validateFields();
        if (state.required === true && state.length == 0) {
            return false;
        }
        return state.valid;
    }

    return {
        state,
        validate,
    };
}
