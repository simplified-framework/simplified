var elixir = require('./elixir');

elixir(function(mix) {
    mix
        .sass("app/resources/assets/scss/**/*.scss")
        .copy('app/resources/vendor/jquery/jquery.min.js', 'public/js')
        .copy('app/resources/vendor/bootstrap-sass/assets/fonts/bootstrap/*', 'public/fonts')
});
