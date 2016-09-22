var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

// "maatwebsite/excel": "~2.0",
elixir(function(mix) {
    mix.sass('app.scss')
       .version([
            'public/css/app.css'
        ])
       .browserSync({ proxy: 'localhost:8000', online: false, });
});
