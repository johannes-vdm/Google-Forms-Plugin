jQuery(document).ready(function ($) {

    const formAction = document.getElementById("bootstrapForm").action;

    $('#bootstrapForm').submit(function (e) {
        window.onbeforeunload = null;
        e.preventDefault();
        $.ajax({
            url: formAction,
            data: $('#bootstrapForm').serialize(),
            type: 'POST',
            dataType: "json",

            error: function () {
                //window.onbeforeunload = null;
                history.back(alert('Quiz Submitted. Thanks.'));
            }
        });
    });
});
