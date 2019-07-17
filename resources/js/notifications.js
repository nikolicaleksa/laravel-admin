/**
 * Display response from AJAX POST request
 *
 * @param message
 * @param type
 * @param response
 */
function displayNotification(message, type, response = false)
{
    if (response !== false && message !== undefined && message.length > 0) {
        response.html(window[type+"_message"](message));
    }
}

/**
 * Remove displayed notifications
 *
 * @param response
 */
function removeNotifications(response = false)
{
    if (response !== false) {
        response.html("");
    }
}

/**
 * Position all notifications
 */
function positionNotifications()
{
}