var gulp = require('gulp');  
var sass = require('gulp-sass');
var watch = require('gulp-watch');
var copy = require('gulp-copy');

/*
var simplified = new function() {
    this.sass = function(file) {
    }

    this.copy = function(src, dst) {
    }
}

var elixir = function(fn) {
     fn(simplified);
};

elixir(function(mix) {
    mix
        .sass("scss/app.scss")
        .copy('vendor/jquery/jquery.min.js', 'public/js')
        .copy('vendor/jquery/jquery.min.js', 'public/js')
        .copy('vendor/jquery/jquery.min.js', 'public/js');
});
*/

gulp.task('scripts', function(){
    gulp.src('app/resources/vendor/jquery/jquery.min.js')
        .pipe(gulp.dest('public/js'));
});

gulp.task('sass', function(){
    gulp.src('./app/resources/scss/**/*.scss')
        .pipe(sass({includePath:'./app/resources/vendor'}))
        .pipe(gulp.dest('public/css'));
});

gulp.task('default', function(){
    gulp.start('sass','scripts');
});

gulp.task('watch', function () {
    gulp.watch('./app/resources/scss/**/*.scss', ['sass']);
});