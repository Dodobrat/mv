const {mix} = require('laravel-mix');

mix.webpackConfig({
    module: {
        rules: [
            { parser: { amd: false } }
        ]
    }
});

mix.js('resources/assets/js/app.js', 'public/js/app.js')
    .styles('resources/assets/css/aos.css','public/css/aos.css')
    .sass('resources/assets/sass/app.scss', 'public/css/app.css')
    .copy('resources/assets/images', 'public/img', true)
    .version()
    .options({
        processCssUrls: false
    });