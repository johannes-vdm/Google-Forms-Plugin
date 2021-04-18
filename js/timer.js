window.onload = function () {

    const MultipleCountdownElements = document.getElementsByClassName('CountdownTime');
    CountdownElements = MultipleCountdownElements[0];
    let time = CountdownElements.getAttribute('value');

    var refreshTimer = setInterval(updateCountdown, 1000);

    function updateCountdown() {
        if (time < 3600 && time >= 0) {
            let minutes = Math.floor(time / 60);
            let seconds = time % 60;

            seconds = ('0' + seconds).slice(-2);
            minutes = ('0' + minutes).slice(-2);

            CountdownElements.innerHTML = `${minutes}:${seconds}`;
            time--;

        } else if (time > 3600) {
            let hours = Math.floor(time / 3600);
            let minutes = Math.floor(time / 60 - 60);
            let seconds = time % 60;

            seconds = ('0' + seconds).slice(-2);
            minutes = ('0' + minutes).slice(-2);
            hours = ('0' + hours).slice(-2);

            CountdownElements.innerHTML = `${hours}:${minutes}:${seconds}`;
            time--;

        } else if (time < 0) {
            time = '';
            console.log("STOP");
            clearInterval(refreshTimer);
            document.cookie = ("JSCountdown", "Finished");
            //document.getElementsByClassName("gsc-search-box")[0].submit();
            document.getElementById("bootstrapForm").submit();
        }

    }

}
