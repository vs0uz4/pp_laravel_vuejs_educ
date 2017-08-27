const { mix } = require('laravel-mix')
const LiveReloadPlugin = require('webpack-livereload-plugin')

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

/*
 Webpack Configurations
 Defining through webpack plugin provider settings, so that the jQuery library stays in the global scope.

 jQuery will be available globally through the variables: '$' and 'jQuery'
 */
mix.webpackConfig({
    plugins: [
        new LiveReloadPlugin()
    ]
})

mix.sass('resources/assets/sass/app.scss', 'public/css')

mix.js('resources/assets/js/app.js', 'public/js')
    .sourceMaps()