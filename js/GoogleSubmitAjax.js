
jQuery('#ReadyBtn').submit(function () {
    alert("YES");
    e.preventDefault();

});


//Unresponsive
//COPIED FROM https://stefano.brilli.me/google-forms-html-exporter/
//This should prevent a user from entering the google docs url after the form is submitted to stop users from changing the form after it is submitted(with or without timer.js). 
//Connected to CustomShortcode.php

//jQuery('#bootstrapForm').submit(function (event) {
//    //alert("YES"); 
//    event.preventDefault()
//    var extraData = {}
//    jQuery('#bootstrapForm').ajaxSubmit({
//        data: extraData,
//        dataType: 'jsonp',
//        error: function () {
//
//            alert('Form Submitted. Thanks.')
//
//        }
//    });
//});

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