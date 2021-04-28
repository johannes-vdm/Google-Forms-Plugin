function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        let date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

window.onload = function () {

    const currentUserEmailDivElement = document.getElementById('currentUserEmail');
    console.log(currentUserEmailDivElement);

    currentUserEmailValue = currentUserEmailDivElement.getAttribute('value');
    inputEmailElements = document.getElementsByClassName('emailAddress');

    for (let i = 0; i < inputEmailElements.length; i++) {
        inputEmailElements[i].value = currentUserEmailValue;
    }

    const multipleCountdownElements = document.getElementsByClassName('CountdownTime');

    countdownElements = multipleCountdownElements[0];
    let time = countdownElements.getAttribute('value');
    let refreshTimer = setInterval(updateCountdown, 1000);

    function updateCountdown() {

        if (time > 3600) {
            //STUB >01h
            let hours = Math.floor(time / 3600);
            let minutes = Math.floor(time / 60 - 60);
            let seconds = time % 60;

            seconds = ('0' + seconds).slice(-2);
            minutes = ('0' + minutes).slice(-2);
            hours = ('0' + hours).slice(-2);

            countdownElements.innerHTML = `${hours}:${minutes}:${seconds}`;
            time--;

        } else if (time <= 3600 && time > -1) {
            //STUB between 0 and !=1h01
            let minutes = Math.floor(time / 60);
            let seconds = time % 60;

            seconds = ('0' + seconds).slice(-2);
            minutes = ('0' + minutes).slice(-2);

            countdownElements.innerHTML = `${minutes}:${seconds}`;
            time--;

        } else if (time <= 0) {
            //STUB time over. 
            clearInterval(refreshTimer);
            time = 0;
            let formAction = document.getElementById("bootstrapForm").action;
            jQuery.ajax({
                url: formAction,
                data: jQuery('#bootstrapForm').serialize(),
                type: 'POST',
                dataType: "json",

                error: function () {
                    history.back(alert('Quiz Submitted. Thanks.'));
                    const shortcodeElemnent = document.getElementById('shrtcode');
                    let shortcodeName = shortcodeElemnent.getAttribute('value');
                    echo();
                    setCookie('ReturnedShortcodeCookie', shortcodeName, 1);
                    setCookie('ReturnedURL', window.location["href"], 1);
                    //NOTE send cookie to check if form was submitted per user
                }
            });

        } else {
            console.log(time);

            //STUB should never happen.
            console.error("Time invalid");
        }
    }
}

window.onbeforeunload = function () {
    let formAction = document.getElementById("bootstrapForm").action;
    jQuery.ajax({
        url: formAction,
        data: jQuery('#bootstrapForm').serialize(),
        type: 'POST',
        dataType: "json",

        error: function () {
            //history.back(alert('Quiz Submitted. Thanks.'));
            const shortcodeElemnent = document.getElementById('shrtcode');
            let shortcodeName = shortcodeElemnent.getAttribute('value');
            echo();
            setCookie('ReturnedShortcodeCookie', shortcodeName, 1);
            setCookie('ReturnedURL', window.location["href"], 1);
        }
    });
    return true;
}
