var elixir = require('./elixir');

elixir(function(mix) {
    mix
        .sass("assets/scss/**/*.scss")
        .copy('vendor/jquery/jquery.min.js', 'public/js')
        .copy('vendor/bootstrap-sass/assets/fonts/bootstrap/*', 'public/fonts')
});
