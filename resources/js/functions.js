/* HTTP codes */
const http_200s = [200];
const http_400s = [400, 401, 404, 422];
const http_500s = [500];

/**
 * Execute AJAX GET request
 *
 * @param url
 * @param after_function
 */
function ajax_get(url, after_function = false)
{
    $.ajax({
        type: "GET",
        url: url,
        dataType: "json",
        processData: false,
        contentType: false,
        cache: false,

        /* Ajax completes */
        success: function (result) {
            /* Remove old notifications */
            removeNotifications();

            /* If the user should be redirected*/
            if (result.redirect) {
                window.location.href = result.redirect;
            } else if (result.code) {
                /* HTTP 200 codes*/
                if (http_200s.indexOf(result.code) > -1) {
                    displayNotification(result.response, "success");
                }

                /* HTTP 400 codes */
                else if (http_400s.indexOf(result.code) > -1) {
                    displayNotification(result.response, "warning");
                }

                /* HTTP 500 codes */
                else if (http_500s.indexOf(result.code) > -1) {
                    displayNotification(result.response, "danger");
                }
            }

            /* Position notifications */
            positionNotifications();

            /* Execute the after function */
            if (after_function !== false) {
                after_function(result);
            }
        },

        /* If Ajax failed */
        error: function (xhr, textStatus, errorThrown) {
            console.log(xhr);
            console.log(textStatus);
            console.log(errorThrown);
        }
    });
}

/**
 * Execute AJAX POST request
 * @param options
 * @param after_function
 * @returns {boolean}
 */
function ajax_post(options = {}, after_function = false)
{
    var form_id, inputs, response_id, reset_form;

    /* Form id */
    if (options.form_id) {
        form_id = options.form_id;
    } else {
        console.log("Form id option missing");

        return false
    }

    /* Form inputs*/
    if (options.inputs) {
        inputs = options.inputs
    } else {
        inputs = false;
    }

    /* Response id*/
    if (options.response_id) {
        response_id = options.response_id;
    } else {
        response_id = false;
    }

    /* Whether to reset form */
    if (options.reset_form) {
        reset_form = options.reset_form;
    } else {
        reset_form = false;
    }

    /* Elements */
    const form = $("#"+form_id);
    const response_element = ((response_id !== false) ? ($("#"+response_id)) : (false));

    /* Check whether the form exists */
    if (form.length === 0) {
        console.log("Form not found: #"+form_id);

        return false
    }

    form.submit(function (e) {
        e.preventDefault();

        /* Inputs */
        if (inputs === false) {
            inputs = [];

            $("#" + form_id).find("input, select, textarea").each(function () {
                let element = $(this).attr("name");

                if (element !== undefined) {
                    inputs.push(element.replace("[]", ""));
                }
            });

            function onlyUnique(value, index, self)
            {
                return self.indexOf(value) === index;
            }

            inputs = inputs.filter(onlyUnique);
        }

        const length = inputs.length;

        /* Remove errors and responses*/
        for (let i = 0; i < length; i++) {
            $("#"+inputs[i]+"_div").removeClass("has-error");
            $("#"+inputs[i]+"_error").html("");
        }

        if (response_element !== false) {
            response_element.html("");
        }

        /* Prepare form data */
        const form_data = new FormData(form[0]);

        $.ajax({
            /* Basic options*/
            type: "POST",
            url: form.attr("action"),
            data: form_data,
            dataType: "json",
            processData: false,
            contentType: false,
            cache: false,

            /* Display please wait message*/
            beforeSend: function () {
                displayNotification(please_wait, "info", response_element);
            },

            /* If Ajax completes */
            success: function (result) {
                /* Remove old notifications */
                removeNotifications(response_element);

                /* If the user should be redirected*/
                if (result.redirect) {
                    window.location.href = result.redirect;
                } else if (result.code) {
                    /* HTTP 200 codes*/
                    if (http_200s.indexOf(result.code) > -1) {
                        displayNotification(result.response, "success", response_element);

                        if (reset_form) {
                            form.find("input, textarea").val("");
                        }
                    }

                    /* HTTP 400 codes */
                    else if (http_400s.indexOf(result.code) > -1) {
                        displayNotification(result.response, "warning", response_element);

                        if (result['messages'] !== undefined) {
                            for (let i = 0; i < length; i++) {
                                if (result['messages'][inputs[i]]) {
                                    $("#"+inputs[i]+"_div").addClass("has-error");
                                    $("#"+inputs[i]+"_error").html(result['messages'][inputs[i]]);
                                }
                            }
                        }
                    }

                    /* HTTP 500 codes */
                    else if (http_500s.indexOf(result.code) > -1) {
                        displayNotification(result.response, "danger", response_element);
                    }
                }

                /* Position notifications */
                positionNotifications();

                /* Execute the after function */
                if (after_function !== false) {
                    after_function(result);
                }
            },

            /* If Ajax failed */
            error: function (xhr, textStatus, errorThrown) {
                console.log(xhr);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    });
}