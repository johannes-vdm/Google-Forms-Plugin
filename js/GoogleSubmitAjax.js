jQuery(document).ready(function ($) {
    //When the form is submitted...

    $('#bootstrapForm').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: 'https://docs.google.com/forms/d/e/1FAIpQLSdjeZagH9IK7VqMNZR3dkX-DBQmK3XAfj42rzDWxMmiKpHzSw/formResponse',     //The public Google Form //url, but replace /view with /formResponse
            data: $('#bootstrapForm').serialize(), //Nifty jquery function that gets all the input data
            type: 'POST', //tells ajax to post the data to the url
            dataType: "json", //the standard data type for most ajax requests

            error: function () {
                alert('Form Submitted. Thanks.')
            }
        });
    });
});