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
        error: function(response) {
            let statusClass = statusHttpClassAlert(response.status)
            if(hasErrors(response))
                for (let [_, message] of Object.entries(response.responseJSON.errors)) {
                    message_alert(message, statusClass);
                }
            else 
                message_alert('Ocorreu um erro, tente novamente mais tarde.', statusClass);
        },
    });
}

function hasErrors(response){
    return response && response.responseJSON && response.responseJSON.errors;
}

function statusHttpClassAlert(status){
    if(status < 200)
        return 'alert-info';
    if(status < 300)
        return 'alert-success';
    if(status < 400)
        return 'alert-primary';
    if(status < 500)
        return 'alert-warning';
   
    return 'alert-danger';
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