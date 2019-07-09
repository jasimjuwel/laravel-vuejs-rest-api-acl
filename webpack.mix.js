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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/user-management/role/role.js', 'public/js/user-management')
    .js('resources/js/user-management/user/user.js', 'public/js/user-management')
    .js('resources/js/user-management/department/department.js', 'public/js/user-management')
    .js('resources/js/user-management/change-password/change_password.js', 'public/js/user-management')
    .sass('resources/sass/app.scss', 'public/css');
