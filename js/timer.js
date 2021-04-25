function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

window.onload = function () {

    const shortcodeCurrent = document.getElementById("Shortcodegrab");
    if (typeof (shortcodeCurrent) != 'undefined' && shortcodeCurrent != null) {

        let shortcodeCurrentName = shortcodeCurrent.getAttribute('value');
        setCookie('currentShortcodeCookie', shortcodeCurrentName, 1);
        console.log(shortcodeCurrentName);
    }


    const multipleCountdownElements = document.getElementsByClassName('CountdownTime');

    countdownElements = multipleCountdownElements[0];
    let time = countdownElements.getAttribute('value');
    var refreshTimer = setInterval(updateCountdown, 1000);

    function updateCountdown() {
        if (time <= 3600 && time > 0) {
            //STUB between 0 and !=1h01
            let minutes = Math.floor(time / 60);
            let seconds = time % 60;

            seconds = ('0' + seconds).slice(-2);
            minutes = ('0' + minutes).slice(-2);

            countdownElements.innerHTML = `${minutes}:${seconds}`;
            time--;

        } else if (time > 3600) {
            //STUB >01h
            let hours = Math.floor(time / 3600);
            let minutes = Math.floor(time / 60 - 60);
            let seconds = time % 60;

            seconds = ('0' + seconds).slice(-2);
            minutes = ('0' + minutes).slice(-2);
            hours = ('0' + hours).slice(-2);

            countdownElements.innerHTML = `${hours}:${minutes}:${seconds}`;
            time--;

        } else if (time <= 0) {
            //STUB time over. 
            time = '';
            clearInterval(refreshTimer);
            //document.getElementsByClassName("btn").click;
            // document.getElementById("bootstrapForm").submit();
            // document.getElementById('loginSubmit').click();
            //if (!allAreFilled) {
            //    alert("You didn't fill in the required fields. Please do the quiz again.");

            var formAction = document.getElementById("bootstrapForm").action;

            jQuery.ajax({
                url: formAction,
                data: jQuery('#bootstrapForm').serialize(),
                type: 'POST',
                dataType: "json",

                error: function () {

                    history.back(alert('Quiz Submitted. Thanks.'));


                    const shortcodeElemnent = document.getElementById('shrtcode');

                    let shortcodeName = shortcodeElemnent.getAttribute('value');

                    setCookieSubmit('shortcodeCookie', shortcodeName, 1);
                    //NOTE send cookie to check if form was submitted per user
                }
            });


            //}
        } else {
            //STUB should never happen.
            console.error("Time invalid");
        }
    }
}
