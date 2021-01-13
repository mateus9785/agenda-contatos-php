function message_alert(message, classname){
    $("#message-alert").text(message)
    $("#div-message-alert").addClass(classname).removeClass("hide").addClass("show");
    setTimeout(function(){ 
        $("#div-message-alert").removeClass("show").addClass("hide").removeClass(classname);
    }, 3000);
}

function requestAjax(method, url, data, sucessMethod) {
    $.ajax({
        method,
        url,
        data,
        success: function(response) {
            sucessMethod(response);
        },
        error: function() {
            message_alert('Ocorreu um erro, tente novamente mais tarde.', 'alert-danger');
        },
    });
}

function maskCep(value) {
    value = value.replace(/\D/g, "");
    value = value.replace(/(\d{2})(\d)/, "$1.$2");
    value = value.replace(/(\d{3})(\d)/, "$1-$2");
    return value;
}

function maskPhone(value) {
    value = value.replace(/\D/g, "").replace(/^0/, "")

    if (value) {
        if (value.length > 10) {
            value = value.replace(/^(\d\d)(\d{5})(\d{4}).*/, "($1) $2-$3");
        } else if (value.length > 5 && value.length != 6) {
            value = value.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1) $2-$3");
        } else if (value.length > 2) {
            value = value.replace(/^(\d\d)(\d{0,5})/, "($1) $2");
        } else {
            value = value.replace(/^(\d*)/, "($1");
        }
    }
    return value;
}