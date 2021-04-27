jQuery(document).ready(function ($) {

    var exampleJS = "hi!";

    $.ajax({
        //url:// 'http://localhost/wp/',
        url: window.location, //points to the current url.change is needed.
        type: 'POST',
        dataType: 'html',
        data: {
            examplePHP: exampleJS
        },
        success: function (response) {
            console.log("Successful! My post data is: " + exampleJS);
        },
        error: function (error) {
            console.log("error");
        }
    });

});