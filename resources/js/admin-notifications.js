/**
 * Display response from AJAX POST request
 *
 * @param message
 * @param type
 * @param response
 */
function displayNotification(message, type, response = false)
{
    PNotify.removeAll();

    if (message !== undefined && message.length > 0) {
        new PNotify({
            title: window[type+"_title"],
            text: message,
            type: type,
            addclass: "alert-"+type,
            buttons: {
                sticker: false
            }
        });
    }

    PNotify.positionAll();
}

/**
 * Remove displayed notifications
 *
 * @param response
 */
function removeNotifications(response = false)
{
    PNotify.removeAll();
}

/**
 * Position all notifications
 */
function positionNotifications()
{
    PNotify.positionAll();
}