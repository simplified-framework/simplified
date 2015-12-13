var gulp = require('gulp');
var sass = require('gulp-sass');
var plumber = require('gulp-plumber');
var notify = require('gulp-notify');

var runSequence = require('run-sequence');

module.exports = function(fn) {
    gulp.task('default', function() {
        var mix = new function() {
            this.sass = function(file) {
                gulp.src(file)
                    .pipe(plumber({errorHandler:function(error){
                        notify({title:'Simplified Build',icon:__dirname + '/icons/error.png'}).write(error.message);
                    }}))
                    .pipe(sass({includePath:'./app/resources/vendor',outputStyle:'compressed'})) // compresseed / expanded
                    .pipe(gulp.dest('public/css'));

                return this;
            };

            this.copy = function(src, dst) {
                gulp.src(src)
                    .pipe(gulp.dest(dst));

                return this;
            };
        };

        fn(mix);
    });
};