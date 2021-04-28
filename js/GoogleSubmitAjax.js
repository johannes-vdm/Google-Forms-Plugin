jQuery(document).ready(function ($) {
    const shortcodeElemnent = document.getElementById('shrtcode');
    let shortcodeName = shortcodeElemnent.getAttribute('value');
    const formAction = document.getElementById("bootstrapForm").action;

    $('#bootstrapForm').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: formAction,
            data: $('#bootstrapForm').serialize(),
            type: 'POST',
            dataType: "json",

            error: function () {

                history.back(alert('Quiz Submitted. Thanks.'));

                setCookie('ReturnedShortcodeCookie', shortcodeName, 1);

            }
        });
    });
});

