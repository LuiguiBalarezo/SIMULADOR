var ValidateInputFormWithParsley = {
    validate: function(selectorInputsForm) {
        var messagesError = "";
        for (var i = 0; i < selectorInputsForm.length; i++) {
            if ($(selectorInputsForm[i]).parsley().isValid()) {
                if ($(selectorInputsForm[i]).prop('tagName') == "SELECT") {
                    $(selectorInputsForm[i]).parent().removeClass("has-error");
                    var node = $(selectorInputsForm[i]).parent().find(".select2-container");
                    node = $(node).find("span.selection");
                    node = $(node).children();
                    $(node).removeClass("border-input-error");
                } else {
                    $(selectorInputsForm[i]).parent().removeClass("has-error");
                }
            } else {
                if ($(selectorInputsForm[i]).prop('tagName') == "SELECT") {
                    $(selectorInputsForm[i]).parent().addClass("has-error");
                    var node = $(selectorInputsForm[i]).parent().find(".select2-container");
                    node = $(node).find("span.selection");
                    node = $(node).children();
                    $(node).addClass("border-input-error");
                } else {
                    $(selectorInputsForm[i]).parent().addClass("has-error");
                }
                messagesError += "<li>" + ParsleyUI.getErrorsMessages($(selectorInputsForm[i]).parsley()) + "</li>";
            }
        }
        if (messagesError.length > 0) {
            GenericModal.show("danger", "<ul>" + messagesError + "</ul>");
            return false;
        }
        return true;
    }
};
