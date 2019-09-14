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

mix.scripts([
    'public/assets/js/jquery.min.js',
    'public/assets/js/bootstrap.bundle.min.js',
    'public/assets/js/metisMenu.min.js',
    'public/assets/js/jquery.slimscroll.js',
    'public/assets/js/waves.min.js',
    'public/plugins/jquery-sparkline/jquery.sparkline.min.js',
    'public/plugins/d3/d3.min.js',
    'public/plugins/c3/c3.min.js',
    'public/plugins/morris/morris.min.js',
    'public/plugins/raphael/raphael-min.js',
    'public/plugins/datatables/jquery.dataTables.min.js',
    'public/plugins/datatables/dataTables.bootstrap4.min.js',
    'public/plugins/datatables/dataTables.responsive.min.js',
    'public/plugins/datatables/responsive.bootstrap4.min.js',
    'public/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
    'public/plugins/sweet-alert2/sweetalert2.min.js',
    'public/plugins/moment/moment.js',
    'public/plugins/fullcalendar/js/fullcalendar.min.js',
    'public/plugins/fullcalendar/js/rrule-calendar.min.js',
    'public/plugins/select2/js/select2.full.min.js',
    'public/assets/js/app.js',
    'public/assets/js/contents/*.js'
    ], 'public/js/app.js')
    .styles([
    'public/plugins/morris/morris.css',
    'public/plugins/c3/c3.min.css',
    'public/assets/css/bootstrap.min.css',
    'public/assets/css/metismenu.min.css',
    'public/plugins/datatables/dataTables.bootstrap4.min.css',
    'public/plugins/datatables/buttons.bootstrap4.min.css',
    'public/plugins/datatables/responsive.bootstrap4.min.css',
    'public/plugins/sweet-alert2/sweetalert2.min.css',
    'public/plugins/fullcalendar/css/fullcalendar.min.css',
    'public/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
    'public/plugins/select2/css/select2.min.css',
    'public/assets/css/icons.css',
    'public/assets/css/style.css',
    'public/assets/css/custom.css'
], 'public/css/app.css').version();
