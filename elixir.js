var gulp = require('gulp');
var sass = require('gulp-sass');
var plumber = require('gulp-plumber');
var notify = require('gulp-notify');
var del = require('del');
var runSequence = require('run-sequence');

module.exports = function(fn) {
    var tasks = [];
    var count = 0;
    var mix = new function() {
        this.sass = function(file) {
            var key = "sass_" + count;

            gulp.task(key, function(){
                gulp.src(file)
                    .pipe(plumber({errorHandler:function(error){
                        notify({title:'Simplified Build',icon:__dirname + '/icons/error.png'}).write(error.message);
                    }}))
                    .pipe(sass({includePath:'./app/resources/vendor',outputStyle:'compressed'})) // compresseed / expanded
                    .pipe(gulp.dest('public/css'))
                    .pipe(
                        notify({title:'Simplified Build',message:'Build finished',icon:__dirname + '/icons/finished.png',onLast:true})
                    );
            });
            tasks.push(key);
            count++;

            return this;
        };

        this.copy = function(src, dst) {
            var key = "copy_" + count;

            gulp.task(key, function(){
                gulp.src(src)
                    .pipe(gulp.dest(dst));
            });
            tasks.push(key);
            count++;

            return this;
        };
    };

    fn(mix);

    gulp.task('clean', function() {
        del(['public/css','public/js', 'public/fonts']);
    });

    gulp.task('build', function(){
        for (var i = 0; i < tasks.length; i++) {
            gulp.start(tasks[i]);
        }
    });

    gulp.task('default', function(){
        runSequence(
            'clean',
            'build'
        );
    });
};