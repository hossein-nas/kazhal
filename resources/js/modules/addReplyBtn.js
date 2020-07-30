export default function() {
    let comments = $("#comments-index .comments-item");
    if (comments.length) {
        comments.each((ind, item) => {
            let reply_btn = $(item).find(".reply-btn");
            let reply_id = reply_btn.data("reply-id");
            let replier = $(item)
                .find(".user-name")
                .html();

            reply_btn.bind("click", () => {
                addReply(reply_id, replier.trim());
            });
        });
    }
}

function addReply(reply_id, replier) {
    let reply_box = $(".new-comment");
    let reply_to = reply_box.find(".head-section .reply-to");

    /**
     * Adding Replier name to reply-to box
     */
    reply_to.html(replier);
    reply_to.addClass("active");
    scrollTo(reply_box);
    // adding replier id to hidden input
    reply_box.find("input.parent_id").val(reply_id);

    /**
     * finally adding Cancel click event on reply-to box
     */
    reply_to.bind("click", RevertReplying);
}

function scrollTo(elem) {
    $([document.documentElement, document.body]).animate(
        {
            scrollTop: elem.offset().top - 50,
        },
        300
    );
}

function RevertReplying(event) {
    /**
     * Emptying .reply-to elem
     */
    $(event.target)
        .html("")
        .removeClass("active");

    /**
     * emptying hidden Input for parent_id
     */
    $(".new-comment input.parent_id").val("");
}
