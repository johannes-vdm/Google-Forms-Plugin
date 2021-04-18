

function ajaxSubmit() {

    console.log("YES");

    var submitform = jQuery(this).serialize();

    jQuery.ajax({
        type: "POST",
        url: "/wp-admin/admin-ajax.php", // URL to admin-ajax.php
        data: submitform,
        success: function (data) {
            jQuery(".feedback").html(data); // empty div to show returned data
        }
    });

    return false;
}



jQuery('#form_submit').submit(function () {
    alert("HELLO");
});

jQuery(document).ready(function () {
    //  alert("JQ HERE");
});

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
    })
})


//jQuery(document).ready(function ($) {
//    $("#ReadyForm").submit(function () {
//        alert("Your book is overdue.");
//    });
//
//});

//$("#bootstrapForm").submit(function (e) {
//    alert("THERE");
//    e.preventDefault();
//    var extraData = {}
//    $('#bootstrapForm').ajaxSubmit({
//        data: extraData,
//        dataType: 'jsonp',  // This won't really work. It's just to use a GET instead of a POST to allow cookies from different domain.
//        error: function () {
//            // Submit of form should be successful but JSONP callback will fail because Google Forms
//            // does not support it, so this is handled as a failure.
//            alert('Form Submitted. Thanks.')
//            // You can also redirect the user to a custom thank-you page:
//            // window.location = 'http://www.mydomain.com/thankyoupage.html'
//        }
//    })
//})


//window.onload = function () {
//    alert("HELLO");
//    $('#bootstrapForm').submit(function (event) {
//        event.preventDefault()
//        var extraData = {}
//        $('#bootstrapForm').ajaxSubmit({
//            data: extraData,
//            dataType: 'jsonp',  // This won't really work. It's just to use a GET instead of a POST to allow cookies from different domain.
//            error: function () {
//                // Submit of form should be successful but JSONP callback will fail because Google Forms
//                // does not support it, so this is handled as a failure.
//                alert('Form Submitted. Thanks.')
//                // You can also redirect the user to a custom thank-you page:
//                // window.location = 'http://www.mydomain.com/thankyoupage.html'
//            }
//        })
//    })
//}
// This script requires jQuery and jquery-form plugin
// You can use these ones from Cloudflare CDN:
// <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
// <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" integrity="sha256-2Pjr1OlpZMY6qesJM68t2v39t+lMLvxwpa8QlRjJroA=" crossorigin="anonymous"></script>
//
///////////////////////

//alert("HELLo");



//$("#ReadyForm").submit(function (e) {
//    alert("THERE");
//    e.preventDefault();
//    var form = $(this);
//    var url = form.attr('action');

//    $.ajax({
//        type: "POST",
//        url: url,
//        data: form.serialize(), // serializes the form's elements.
//        success: function (data) {
//            alert(data); // show response from the php script.
//        }
//    });

//});

//document.querySelector('#ReadyForm').submit(function (event) {
//
//    console.log("SUBMITTED");
//    event.preventDefault()
//    var extraData = {}
//    document.querySelector('#bootstrapForm').fetch({
//
//        data: extraData,
//        dataType: 'jsonp',  // This won't really work. It's just to use a GET instead of a POST to allow cookies from different domain.
//        error: function () {
//            // Submit of form should be successful but JSONP callback will fail because Google Forms
//            // does not support it, so this is handled as a failure.
//            alert('Form Submitted. Thanks.')
//            // You can also redirect the user to a custom thank-you page:
//            // window.location = 'http://www.mydomain.com/thankyoupage.html'
//        }
//    })
//
//});
//document.querySelector('#bootstrapForm').submit(function (event) {
//
//    event.preventDefault()
//    var extraData = {}
//    document.querySelector('#bootstrapForm').fetch({
 //       data: extraData,
 //       dataType: 'jsonp',  // This won't really work. It's just to use a GET instead of a POST to allow cookies from different domain.
 //       error: function () {
            // Submit of form should be successful but JSONP callback will fail because Google Forms
            // does not support it, so this is handled as a failure.
    //        alert('Form Submitted. Thanks.')
            // You can also redirect the user to a custom thank-you page:
            // window.location = 'http://www.mydomain.com/thankyoupage.html'
 //       }
//    })
//})


//$(document).ready(function () {
//    $("form").on('submit', function (e) {
//        alert("Form submitted");
//        return false;
//
//    });
//});
//
//
//$('#bootstrapForm').submit(function (event) {
//    event.preventDefault()
//    var extraData = {}
//    $('#bootstrapForm').ajaxSubmit({
//        data: extraData,
//        dataType: 'jsonp',  // This won't really work. It's just to use a GET instead of a POST to allow cookies from different domain.
//        error: function () {
//            // Submit of form should be successful but JSONP callback will fail because Google Forms
//            // does not support it, so this is handled as a failure.
//            alert('Form Submitted. Thanks.')
//            // You can also redirect the user to a custom thank-you page:
//            // window.location = 'http://www.mydomain.com/thankyoupage.html'
//        }
//    })
//})
/////////////////////////////////
// This script requires jQuery and jquery-form plugin
// You can use these ones from Cloudflare CDN:
// <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
// <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js" integrity="sha256-2Pjr1OlpZMY6qesJM68t2v39t+lMLvxwpa8QlRjJroA=" crossorigin="anonymous"></script>
//
/*
$('#bootstrapForm').submit(function (event) {
    event.preventDefault()
    var extraData = {}
    $('#bootstrapForm').ajaxSubmit({
        data: extraData,
        dataType: 'jsonp',  // This won't really work. It's just to use a GET instead of a POST to allow cookies from different domain.
        error: function () {
            // Submit of form should be successful but JSONP callback will fail because Google Forms
            // does not support it, so this is handled as a failure.
            alert('Form Submitted. Thanks.')
            // You can also redirect the user to a custom thank-you page:
            // window.location = 'http://www.mydomain.com/thankyoupage.html'
        }
    })
})

*/
/*
document.querySelector('#bootstrapForm').submit(function (event) {
    event.preventDefault()
    var extraData = {}
    document.querySelector('#bootstrapForm').fetch({
        data: extraData,
        dataType: 'jsonp',  // This won't really work. It's just to use a GET instead of a POST to allow cookies from different domain.
        error: function () {
            // Submit of form should be successful but JSONP callback will fail because Google Forms
            // does not support it, so this is handled as a failure.
            alert('Form Submitted. Thanks.')
            // You can also redirect the user to a custom thank-you page:
            // window.location = 'http://www.mydomain.com/thankyoupage.html'
        }
    })
})

*/