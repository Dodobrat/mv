const {mix} = require('laravel-mix');

mix.webpackConfig({
    module: {
        rules: [
            { parser: { amd: false } }
        ]
    }
});

mix.js('resources/assets/js/app.js', 'public/js/app.js')
    .copy('resources/assets/css/aos.css','public/css/aos.css', true)
    .sass('resources/assets/sass/app.scss', 'public/css/app.css')
    .copy('resources/assets/images', 'public/img', true)
    .copy('resources/assets/fonts', 'public/font', true)
    .copy('resources/assets/webfonts', 'public/webfonts', true)
    .version()
    .options({
        processCssUrls: false
    });