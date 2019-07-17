const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.sass('resources/sass/authenitcated.scss', 'public/css/admin-app.css')
    .sass('resources/sass/guest.scss', 'public/css/guest-app.css')
    .scripts([
        'node_modules/jquery/dist/jquery.js',
        'node_modules/bootstrap/dist/js/bootstrap.js',
        'resources/js/notifications.js',
        'resources/js/messages.js',
        'resources/js/functions.js',
        'resources/js/sign-in.js',
    ], 'public/js/guest-app.js')
    .scripts([
        'node_modules/jquery/dist/jquery.js',
        'node_modules/bootstrap/dist/js/bootstrap.js',
        'resources/js/admin-notifications.js',
        'node_modules/nprogress/nprogress.js',
        'node_modules/fastclick/lib/fastclick.js',
        'node_modules/linkwise-pnotify/dist/pnotify.js',
        'node_modules/linkwise-pnotify/dist/pnotify.animate.js',
        'node_modules/linkwise-pnotify/dist/pnotify.buttons.js',
        'node_modules/linkwise-pnotify/dist/pnotify.callbacks.js',
        'node_modules/linkwise-pnotify/dist/pnotify.confirm.js',
        'node_modules/linkwise-pnotify/dist/pnotify.desktop.js',
        'node_modules/linkwise-pnotify/dist/pnotify.mobile.js',
        'node_modules/linkwise-pnotify/dist/pnotify.nonblock.js',
        'node_modules/@adactive/bootstrap-tagsinput/dist/bootstrap-tagsinput.js',
        'node_modules/@activix/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js',
        'node_modules/ckeditor/ckeditor.js',
        'node_modules/highcharts/highcharts.js',
        'node_modules/highcharts/highcharts-more.js',
        'node_modules/highcharts/modules/solid-gauge.js',
        'resources/js/functions.js',
        'resources/js/admin.js',
    ], 'public/js/admin-app.js')
    .copy('node_modules/ckeditor/config.js', 'public/ckeditor/config.js')
    .copy('node_modules/ckeditor/styles.js', 'public/ckeditor/styles.js')
    .copy('node_modules/ckeditor/contents.css', 'public/ckeditor/contents.css')
    .copyDirectory('node_modules/ckeditor/assets/', 'public/ckeditor/assets/')
    .copyDirectory('node_modules/ckeditor/lang/', 'public/ckeditor/lang/')
    .copyDirectory('node_modules/ckeditor/plugins/', 'public/ckeditor/plugins/')
    .copyDirectory('node_modules/ckeditor/skins/', 'public/ckeditor/skins/');
