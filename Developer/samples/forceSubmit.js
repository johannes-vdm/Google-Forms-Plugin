var inputs = $("form#myForm input, form#myForm textarea");

var validateInputs = function validateInputs(inputs) {
    var validForm = true;
    inputs.each(function (index) {
        var input = $(this);
        if (!input.val() || (input.type === "radio" && !input.is(':checked'))) {
            $("#subnewtide").attr("disabled", "disabled");
            validForm = false;
        }
    });
    return validForm;
}


inputs.change(function () {
    if (validateInputs(inputs)) {
        $("#subnewtide").removeAttr("disabled");
    }
});