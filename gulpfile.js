var elixir = require('laravel-elixir');

var paths = {
    'bootstrap': 'vendor/bower_components/bootstrap/',
    'jquery': 'vendor/bower_components/jquery/dist/',
    'fontawesome': 'vendor/bower_components/fontawesome/'
};

elixir(function(mix) {
    mix.less('app.less')

    .scripts([
        paths.jquery + 'jquery.js',
        paths.bootstrap + 'dist/js/bootstrap.js',
        'resources/assets/js/prism.js',
        'resources/assets/js/app.js'
    ], 'public/js/app.js', './')

    .copy(paths.bootstrap + 'fonts/**', 'public/fonts')
    .copy(paths.fontawesome + 'fonts/**', 'public/fonts')

    .version(['css/app.css', 'js/app.js']);
});
