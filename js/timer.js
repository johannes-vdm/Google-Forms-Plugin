window.onload = function () {

    const MultipleCountdownElements = document.getElementsByClassName('CountdownTime');

    console.log(MultipleCountdownElements.length);

    //dont enter with no classes
    if (MultipleCountdownElements.length > 0) {

        CountdownElements = MultipleCountdownElements[0];

        console.log(CountdownElements);

        let time = CountdownElements.getAttribute('value');

        setInterval(updateCountdown, 1000);

        function updateCountdown() {
            const minutes = Math.floor(time / 60);
            let seconds = time % 60;

            CountdownElements.innerHTML = `${minutes}:${seconds}`;
            time--;
        }

        if (time < 0) {
            getElementsByClassName('btn-primary')

        }
    }

}
