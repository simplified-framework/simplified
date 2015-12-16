var build = require('simplified-build');

build(function(mix) {
    mix
        .sass("assets/scss/**/*.scss")
        .copy('vendor/jquery/jquery.min.js', 'public/js')
        .copy('vendor/bootstrap-sass/assets/fonts/bootstrap/*', 'public/fonts')
        .copy('vendor/bootstrap-sass/assets/javascripts/bootstrap.min.js', 'public/js')
});
