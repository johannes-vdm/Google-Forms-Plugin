$('#formupload').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type: 'POST',
        url: $('#formupload').attr('action'),
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            if (condition) { }
            else { }
        }
    })
})

var valid = false;

jQuery('input[type=text]').each(function () {
    if (jQuery(this).val().length == 0) {
        jQuery(this).addClass('hightlight');
        alert('Empty input field')
        valid = false;
    } else {
        valid = true;
    }
});


if (valid == false) return;
console.log('All input fields are filled in..');

//BROKEN
//jQuery("#ReadyBtn").submit(function (e) {
//    e.preventDefault();
//    alert("Form submitted");
//});

//CHECK
//jQuery(document).ready(function () {
//   alert("JQ HERE");
//});