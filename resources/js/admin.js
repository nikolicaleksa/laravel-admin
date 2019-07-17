$(function () {
    // Sidebar
    const body = $('body'),
        menu_toggle = $('#menu_toggle'),
        sidebar_menu = $('#sidebar-menu'),
        sidebar_footer = $('.sidebar-footer'),
        left_col = $('.left_col'),
        right_col = $('.right_col'),
        nav_menu = $('.nav_menu'),
        footer = $('footer');
    const setContentHeight = function () {
        right_col.css('min-height', $(window).height());
        let bodyHeight = body.outerHeight(),
            footerHeight = body.hasClass('footer_fixed') ? -10 : footer.height(),
            leftColHeight = left_col.eq(1).height() + sidebar_footer.height(),
            contentHeight = bodyHeight < leftColHeight ? leftColHeight : bodyHeight;
        contentHeight -= nav_menu.height() + footerHeight;
        right_col.css('min-height', contentHeight);
    };

    sidebar_menu.find('a').on('click', function (ev) {
        const li = $(this).parent();

        if (li.is('.active')) {
            li.removeClass('active active-sm');
            $('ul:first', li).slideUp(function () {
                setContentHeight();
            });
        } else {
            if (!li.parent().is('.child_menu')) {
                sidebar_menu.find('li').removeClass('active active-sm');
                sidebar_menu.find('li ul').slideUp();
            } else {
                if (body.is(".nav-sm")) {
                    sidebar_menu.find("li").removeClass("active active-sm");
                    sidebar_menu.find("li ul").slideUp();
                }
            }
            li.addClass('active');
            $('ul:first', li).slideDown(function () {
                setContentHeight();
            });
        }
    });

    // Menu toggle
    menu_toggle.on('click', function () {
        if (body.hasClass('nav-md')) {
            sidebar_menu.find('li.active ul').hide();
            sidebar_menu.find('li.active').addClass('active-sm').removeClass('active');
        } else {
            sidebar_menu.find('li.active-sm ul').show();
            sidebar_menu.find('li.active-sm').addClass('active').removeClass('active-sm');
        }
        body.toggleClass('nav-md nav-sm');
        setContentHeight();
    });

    // Active menu
    sidebar_menu.find('li.active ul').each(function () {
        $(this).slideDown();
    });

    // Navigation
    $('.collapse-link').on('click', function () {
        const box_panel = $(this).closest('.x_panel'),
            icon = $(this).find('i'),
            box_content = box_panel.find('.x_content');
        if (box_panel.attr('style')) {
            box_content.slideToggle(200, function () {
                box_panel.removeAttr('style');
            });
        } else {
            box_content.slideToggle(200);
            box_panel.css('height', 'auto');
        }
        icon.toggleClass('fa-chevron-up fa-chevron-down');
    });
    $('.close-link').click(function () {
        let box_panel = $(this).closest('.x_panel');
        box_panel.remove();
    });

    // Tooltip
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

    // NProgress
    NProgress.start();

    // PNotify
    PNotify.prototype.options.styling = "bootstrap3";

    // Tagsinput
    $('.tagsinput').tagsinput({
        confirmKeys: [13, 32, 44]
    });

    // Ckeditor
    if ($("#content").length) {
        window.CKEDITOR_BASEPATH = 'node_modules/ckeditor/';
        const editor = CKEDITOR.replace('content',{
            language: 'en',
            height: '350',
            toolbarGroups: [
                { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
                { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
                { name: 'forms', groups: [ 'forms' ] },
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
                { name: 'links', groups: [ 'links' ] },
                { name: 'insert', groups: [ 'insert' ] },
                { name: 'styles', groups: [ 'styles' ] },
                { name: 'colors', groups: [ 'colors' ] },
                { name: 'tools', groups: [ 'tools' ] },
                { name: 'others', groups: [ 'others' ] },
                { name: 'about', groups: [ 'about' ] }
            ],
            removeButtons: 'Maximize,Form,Find,Templates,Save,Scayt,CopyFormatting,RemoveFormat,Replace,NewPage,Preview,Print,CreateDiv,Blockquote,BidiLtr,BidiRtl,Language,Flash,Smiley,PageBreak,Iframe,Styles,ShowBlocks,About,Radio,Textarea,Select,Button,ImageButton,HiddenField,TextField,Checkbox,SelectAll,Anchor'
        });

        $("#add-post-form, #edit-post-form").submit(function () {
            document.getElementById('content').value = editor.getData();
        });

        // Add post form
        if ($('#add-post-form').length) {
            ajax_post({
                form_id: "add-post-form"
            });
        }

        // Edit post form
        if ($('#edit-post-form').length) {
            // Set selected category
            let category = $("#category_id");

            category.find("option[value=" + category.attr('data-selected') + "]").attr('selected', 'selected');

            // Set selected publish option
            let publish_option = $("#publish_option");

            publish_option.find("option[value=" + publish_option.attr('data-selected') + "]").attr('selected', 'selected');

            ajax_post({
                form_id: "edit-post-form"
            });
        }
    }

    // Posts set active type
    const postsTypeList = $("#posts-type-list");

    if (postsTypeList) {
        let active_post_type = postsTypeList.attr('data-active-type');

        $("#" + active_post_type + "-posts-href").addClass("active");
    }

    // Publishing option
    if ($("#publish_option_div").length) {
        $("#publish_option").change(function () {
            let published_at = $("#published_at_parent");
            let selected_option = $('#publish_option').find(":selected");

            if (selected_option && selected_option.attr('value') === 'schedule') {
                published_at.hide().removeClass('hidden').slideDown();
            } else {
                published_at.slideUp();
            }
        });

        // Datetime picker
        $("#published_at").datetimepicker({
            format: "dd-mm-yyyy hh:ii",
            autoclose: true,
            todayBtn: true,
            minuteStep: 10,
            pickerPosition: 'top-right'
        });
    }

    // Delete confirmation
    $(".delete").click(function (e) {
        e.preventDefault();

        const confirm_message = $(this).attr("data-message");
        const redirect_link = $(this).attr("href");
        const delete_row = $(this).parent().parent();

        new PNotify({
            title: confirm_title,
            text: confirm_message,
            icon: 'glyphicon glyphicon-question-sign',
            hide: false,
            confirm: {
                confirm: true,
                buttons: [{
                    text: yes,
                    addClass: "btn-warning",
                    promptTrigger: true,
                    click: function (notice, value) {
                        notice.remove();
                        ajax_get(redirect_link, function (response) {
                            if (response.code === 200) {
                                delete_row.remove();
                            }
                        });
                    }
                }, {
                    text: no,
                    addClass: "",
                    click: function (notice) {
                        notice.remove();
                        notice.get().trigger("pnotify.cancel", notice);
                    }
                }]
            },
            buttons: {
                sticker: false
            }
        });
    });

    // Approve comment
    const approveComment = $('.approve-comment');

    if (approveComment.length) {
        approveComment.click(function () {
            let comment_id = $(this).attr("data-comment-id");

            ajax_get($(this).attr('data-approve-url'));

            $("#comment-" + comment_id + "-modal").modal('hide');

            setTimeout(function () {
                $("#comment-" + comment_id + "-row").remove();
            }, 350);
        });
    }

    // Unapprove comment
    const unapproveComment = $('.unapprove-comment');

    if (unapproveComment.length) {
        unapproveComment.click(function () {
            let comment_id = $(this).attr("data-comment-id");

            ajax_get($(this).attr('data-unapprove-url'));

            $("#comment-" + comment_id + "-modal").modal('hide');

            setTimeout(function () {
                $("#comment-" + comment_id + "-row").remove();
            }, 350);
        });
    }

    // Add category form
    if ($('#add-category-form').length) {
        ajax_post({
            form_id: 'add-category-form'
        });
    }

    // Edit category form
    if ($('#edit-category-form').length) {
        ajax_post({
            form_id: 'edit-category-form'
        });
    }

    // Add user form
    if ($('#add-user-form').length) {
        ajax_post({
            form_id: 'add-user-form'
        });
    }

    // Edit user form
    if ($('#edit-user-form').length) {
        ajax_post({
            form_id: 'edit-user-form'
        });
    }

    // Settings form
    if ($('#settings-form').length) {
        ajax_post({
            'form_id': 'settings-form'
        });
    }
});

// NProgress
$(window).on("load", function (e) {
    NProgress.done();
});

// Visitor statistics
function showVisitorsStatistics(url, year, month = null)
{
    url = url.replace('year', year);

    if (month !== null) {
        url = url.replace('month', month);
    } else {
        url = url.replace('/month', '');
    }

    ajax_get(url, function (result) {
        Highcharts.chart("visitors-statistics-graph", {
            chart: {
                type: "line"
            },
            title: {
                text: visitors_statistics_for + months[month-1]
            },
            tooltip: {
                enabled: false
            },
            xAxis: {
                categories: Object.keys(result['all'])
            },
            yAxis: {
                title: {
                    text: visits_count
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true,
                        formatter: function () {
                            return ((this.y !== 0) ? (this.y) : (""));
                        }
                    },
                    enableMouseTracking: {
                        enabled: true
                    }
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: visits,
                data: Object.values(result['all'])
            }, {
                name: unique_visits,
                data: Object.values(result['unique'])
            }]
        })
    });
}

// Visitor countries
function showVisitorsCountries(url)
{
    ajax_get(url, function (result) {
        var data = [];

        result.data.forEach(function (item) {
            data.push({
                name: item.country,
                y: item.percentage
            });
        });

        Highcharts.chart('visitors-countries-graph', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: visitor_countries_title
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                colorByPoint: true,
                data: data
            }]
        });
    });
}

// Free space chart
function showFreeSpaceChart(freeSpacePercentage)
{
    Highcharts.chart('free-space-chart', {
        chart: {
            type: 'solidgauge'
        },
        title: null,
        pane: {
            center: ['50%', '85%'],
            size: '170%',
            startAngle: -90,
            endAngle: 90,
            background: {
                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
                innerRadius: '60%',
                outerRadius: '100%',
                shape: 'arc'
            }
        },
        tooltip: {
            enabled: false
        },
        yAxis: {
            min: 0,
            max: 100,
            stops: [
                [0.1, '#DF5353'], // green
                [0.3, '#DDDF0D'], // yellow
                [0.5, '#55BF3B'] // red
            ],
            lineWidth: 0,
            minorTickInterval: null,
            tickAmount: 2,
            title: {
                y: -70
            },
            labels: {
                y: 16
            },
        },
        plotOptions: {
            solidgauge: {
                dataLabels: {
                    y: 5,
                    borderWidth: 0,
                    useHTML: true
                }
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Speed',
            data: [freeSpacePercentage],
            dataLabels: {
                format: '<div style="text-align:center"><span style="font-size:25px;color:' +
                    ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span></div>'
            },
            tooltip: {
                valueSuffix: ' %'
            }
        }]
    });
}