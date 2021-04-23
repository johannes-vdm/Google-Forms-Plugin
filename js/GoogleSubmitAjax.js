//window.onload = function () {
//    alert("YES");
//    document.getElementById("#bootstrapForm").submit();
//    let formSub = document.querySelector("#bootstrapForm");
//
//    let request = new XMLHttpRequest();
//    e.preventDefault();
//    let extraData = {};
//
//    request.data(extraData);
//    request.dataType("jsonp");
//    request.send(data);
//    request.onerror = function () {
//        alert('Form Submitted. Thanks.')
//    };
//}




//jQuery(document).ready(function ($) {
//
//    $('#bootstrapForm').submit(function (e) {
//        e.preventDefault();
//
//        var extraData = {};
//
//        $.ajax({
//            type: 'POST',
//            data: extraData,
//            dataType: 'jsonp',
//            error: function () {
//                alert('Form Submitted. Thanks.')
//            }
//        });
//        return false;
//    });
//});


////selector from your HTML form
//$('#bootstrapForm').submit(function (e) {
//    //prevent the form from submiting so we can post to the google form
//    e.preventDefault();
//    //AJAX request
//    $.ajax({
//        url: 'https://docs.google.com/forms/d/e/1FAIpQLSdjeZagH9IK7VqMNZR3dkX-DBQmK3XAfj42rzDWxMmiKpHzSw/formResponse',     //The public Google Form //url, but replace /view with /formResponse
//        data: $('#bootstrapForm').serialize(), //Nifty jquery function that gets all the input data
//        type: 'POST', //tells ajax to post the data to the url
//        dataType: "json", //the standard data type for most ajax requests
//        headers: {
//            'Content-Type': 'application/json'
//        },
//        statusCode: { //the status code from the POST request
//            0: function (data) { //0 is when Google gives a CORS error, don't worry it went through
//                //success
//                //$('#form-success').text('hooray!');
//                alert(0);
//            },
//            200: function (data) {//200 is a success code. it went through!
//                //success
//                //$('#form-success').text('hooray!');
//                alert(200);
//            },
//            403: function (data) {//403 is when something went wrong and the submission didn't go through
//                //error
//                alert("error");
//                alert('Oh no! something went wrong. we should check our code to make sure everything matches with Google');
//            }
//        }
//    });
//});

//WORKS PERFECTLY BUT WITHOUT FORM SUB
jQuery(document).ready(function ($) {
    //When the form is submitted...

    $('#bootstrapForm').submit(function (e) {
        e.preventDefault();
        var extraData = {};
        //Send the serialized data to mailer.php.

        $.ajax({
            url: 'https://docs.google.com/forms/d/e/1FAIpQLSdjeZagH9IK7VqMNZR3dkX-DBQmK3XAfj42rzDWxMmiKpHzSw/formResponse',     //The public Google Form //url, but replace /view with /formResponse
            data: $('#bootstrapForm').serialize(), //Nifty jquery function that gets all the input data



            type: 'POST', //tells ajax to post the data to the url
            dataType: "json", //the standard data type for most ajax requests
            headers: {
                'Content-Type': 'application/json'
            },

            error: function () {
                alert('Form Submitted. Thanks.')
            }


            //data: extraData,
            //dataType: 'jsonp',
            //error: function () {
            //    alert('Form Submitted. Thanks.')
            //},
            //success: function (data) {
            //    console.log(data);
            //}
            //    $("#success").show().fadeOut(5000); //=== Show Success Message==
            //},
            // error: function (data) {
            //     $("#error").show().fadeOut(5000); //===Show Error Message====
            // }
        });
        //=== To Avoid Page Refresh and Fire the Event "Click"===
        //$.post("mailer.php");
        //Take our response, and replace whatever is in the "form2"
        //div with it.
        // $('#form1').hide();
        // $('#form2').show();
    });
});





//($('#bootstrapForm').submit(function (event) {
//    event.preventDefault()
//    event.stopPropagation();
//    var extraData = {}
//    $('#bootstrapForm').ajaxSubmit({
//        data: extraData,
//        dataType: 'jsonp',  // This won't really work. It's just to use a GET instead of a POST to allow cookies from different domain.
//        error: function () {
//            alert('Form Submitted. Thanks.')
//        }
//    })
//}))(jQuery);