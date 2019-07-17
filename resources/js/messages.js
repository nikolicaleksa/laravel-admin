/**
 * Return HTML code for info message
 *
 * @param message
 *
 * @returns {string}
 */
function info_message(message)
{
    return "<div class=\"alert alert-info alert-dismissible text-center\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>"+message+"</div>";
}

/**
 * Return HTML code for warning message
 *
 * @param message
 *
 * @returns {string}
 */
function warning_message(message)
{
    return "<div class=\"alert alert-warning alert-dismissible text-center\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>"+message+"</div>";
}

/**
 * Return HTML code for danger message
 *
 * @param message
 *
 * @returns {string}
 */
function danger_message(message)
{
    return "<div class=\"alert alert-danger alert-dismissible text-center\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>"+message+"</div>";
}

/**
 * Return HTML code for success message
 *
 * @param message
 *
 * @returns {string}
 */
function success_message(message)
{
    return "<div class=\"alert alert-success alert-dismissible text-center\" role=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>"+message+"</div>";
}

/**
 * Return HTML code for waiting message
 *
 * @param message
 *
 * @returns {string}
 */
function waiting_message() {
    return "<div class=\"text-center\"><i class=\"fa fa-fw fa-spin fa-cog\"></i>"+please_wait+"</div>"
}