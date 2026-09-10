function Notify(type, res, msg = null) {
    var type;
    var icon;
    var message;

    switch (type) {
        case "error":
            type = "error";
            message = msg ?? res.responseJSON.message ?? res.responseText ?? 'Oops! Something went wrong';
            icon = 'fa fa-times-circle';
            break;
        case "success":
            type = "success";
            message = msg ?? res.message ?? 'Congratulate! Operation Successful.';
            icon = 'fa fa-check-circle';
            break;
        case "warning":
            type = "warning";
            message = msg ?? res.message ?? res.responseJSON.message ?? 'Warning! Operation Failed.';
            icon = 'fa fa-info-circle';
            break;
        default:

    }

    Lobibox.notify(type, {
        pauseDelayOnHover: true,
        continueDelayOnInactiveTab: false,
        icon: icon,
        sound: false,
        position: 'top right',
        showClass: 'zoomIn',
        hideClass: 'zoomOut',
        size: 'mini',
        rounded: true,
        delay: 3000,
        msg: message,
    });
}
