window.onload = function () {
    var classValue = document.getElementsByClassName("CountdownTime");

    console.log("LENGTH: " + classValue.length);

    var secondsHTML;

    for (var i = 0; i < classValue.length; i++) {
        secondsHTML = classValue[i].getAttribute('data-value');

        console.log("data-value: " + secondsHTML);
    }

}
