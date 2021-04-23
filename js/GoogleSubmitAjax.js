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




jQuery(document).ready(function ($) {

    $('#bootstrapForm').submit(function (e) {
        e.preventDefault();

        var extraData = {};

        $.ajax({
            type: 'POST',
            data: extraData,
            dataType: 'jsonp',
            error: function () {
                alert('Form Submitted. Thanks.')
            }
        });
        return false;
    });
});




/*
//WORKS PERFECTLY BUT WITHOUT FORM SUB
jQuery(document).ready(function ($) {
    //When the form is submitted...

    $('#bootstrapForm').on('submit', function (e) {
        e.preventDefault();
        var extraData = {};
        //Send the serialized data to mailer.php.
        $.ajax({
            data: extraData,
            dataType: 'jsonp',
            error: function () {
                alert('Form Submitted. Thanks.')
            },
            success: function (data) {
                console.log(data);
            }
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

*/



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