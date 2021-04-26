jQuery(document).ready(function ($) {

    //grab form action
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

                setCookie('shortcodeCookie', 1);
                //NOTE send cookie to check if form was submitted per user
            }
        });
    });
});

function setCookie(name, days) {

    const shortcodeElemnent = document.getElementById('shrtcode');

    let shortcodeName = shortcodeElemnent.getAttribute('value');
    value = shortcodeName;

    console.log(shortcodeName);

    let expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}
