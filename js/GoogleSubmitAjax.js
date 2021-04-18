//Unresponsive
//COPIED FROM https://stefano.brilli.me/google-forms-html-exporter/
//This should prevent a user from entering the google docs url after the form is submitted to stop users from changing the form after it is submitted(with or without timer.js). 
//Connected to CustomShortcode.php

jQuery('#bootstrapForm').submit(function (event) {
    //alert("YES"); 
    event.preventDefault()
    var extraData = {}
    jQuery('#bootstrapForm').ajaxSubmit({
        data: extraData,
        dataType: 'jsonp',  // This won't really work. It's just to use a GET instead of a POST to allow cookies from different domain.
        error: function () {
            // Submit of form should be successful but JSONP callback will fail because Google Forms
            // does not support it, so this is handled as a failure.
            alert('Form Submitted. Thanks.')
            // You can also redirect the user to a custom thank-you page:
            // window.location = 'http://www.mydomain.com/thankyoupage.html'
        }
    });
});

//ATTEMPT TO CONVERT JQUERY TO VANILLA JAVASCRIPT
/*
document.querySelector('#bootstrapForm').submit(function (event) {
    event.preventDefault()
    var extraData = {}
    document.querySelector('#bootstrapForm').fetch({
        data: extraData,
        dataType: 'jsonp',
        error: function () {
            alert('Form Submitted. Thanks.')
        }
    })
})
*/