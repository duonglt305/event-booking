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
mix.js('platform/admin/resources/assets/js/detail.js', 'public/js');
mix.js('platform/admin/resources/assets/js/session.create.js', 'public/js');
mix.js('platform/admin/resources/assets/js/session-types.js', 'public/js');
mix.js('platform/admin/resources/assets/js/speakers.js', 'public/js');
mix.js('platform/admin/resources/assets/js/articles.create-update.js', 'public/js');
mix.js('platform/admin/resources/assets/js/room_capacity.js', 'public/js');
mix.js('platform/admin/resources/assets/js/event-create-update.js', 'public/js');
mix.js('platform/admin/resources/assets/js/event.report.js', 'public/js');
mix.js('platform/admin/resources/assets/js/dashboard.js', 'public/js');
mix.js('platform/admin/resources/assets/js/attendees-verify.js', 'public/js');
mix.js('platform/admin/resources/assets/js/notify.js', 'public/js');
mix.js('platform/admin/resources/assets/js/notification.js', 'public/js');
mix.js('platform/admin/resources/assets/js/contact.js', 'public/js');
mix.js('platform/admin/resources/assets/js/registration.js', 'public/js');



mix.sass('platform/table/resources/assets/css/table.scss', 'public/css');
