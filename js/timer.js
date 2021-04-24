window.onload = function () {
    //NOTE ask user to enter email id

    //NOTE login will not be forced 

    const userEmailElement = document.getElementById("emailAddress");
    if (userEmailElement.length > 0) {
        userEmailElement.value = currentUserEmail;
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
            document.getElementById("bootstrapForm").submit();
            if (!allAreFilled) {
                alert("You didn't fill in the required fields. Please do the quiz again.");
            }
        } else {
            //STUB should never happen.
            console.error("Time invalid");
        }
    }
}
