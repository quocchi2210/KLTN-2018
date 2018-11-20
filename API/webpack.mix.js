var mix = require('laravel-mix');

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

mix.react('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

/**
 * Mix Asset for app
 * Login page
 */
mix.js('resources/assets/js/login.js', 'public/app/js')
    .sass('resources/assets/sass/login.scss', 'public/app/css');

mix.js('resources/assets/js/app.js', 'public/app/js')
    .sass('resources/assets/store/sass/app.scss', 'public/backend/css');
mix.js('resources/assets/js/jquery.js', 'public/js');