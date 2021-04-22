window.onload = function () {
    const multipleCountdownElements = document.getElementsByClassName('CountdownTime');
    const userEmailElement = document.getElementById("emailAddress")

    userEmailElement.value = currentUserEmail;

    countdownElements = multipleCountdownElements[0];
    let time = countdownElements.getAttribute('value');
    var refreshTimer = setInterval(updateCountdown, 1000);

    function updateCountdown() {
        if (time <= 3600 && time > 0) {
            //between 0 and 1h01
            let minutes = Math.floor(time / 60);
            let seconds = time % 60;

            seconds = ('0' + seconds).slice(-2);
            minutes = ('0' + minutes).slice(-2);

            countdownElements.innerHTML = `${minutes}:${seconds}`;
            time--;

        } else if (time > 3600) {
            // >01h
            let hours = Math.floor(time / 3600);
            let minutes = Math.floor(time / 60 - 60);
            let seconds = time % 60;

            seconds = ('0' + seconds).slice(-2);
            minutes = ('0' + minutes).slice(-2);
            hours = ('0' + hours).slice(-2);

            countdownElements.innerHTML = `${hours}:${minutes}:${seconds}`;
            time--;

        } else if (time <= 0) {
            //time over. 
            time = '';
            clearInterval(refreshTimer);
            document.getElementById("bootstrapForm").submit();

        } else {
            //should never happen.
            console.error("Time invalid");
        }
    }
}
