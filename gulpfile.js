var gulp = require('gulp');  
var sass = require('gulp-sass');
var watch = require('gulp-watch');
var notify = require('gulp-notify');

var config = new Object();
config.basepath = "app/resources/";

var simplified = new function() {
    this.sass = function(file) {
        var path = config.basepath + file;
        gulp.src(path)
            .pipe(sass({includePaths:config.basepath + "vendor/*", style:"expanded"})
                .on('error',
                    notify.onError(function(error){
                        return {message:error.message,title:"Error running SASS"};
                    })
                )
            )
            .pipe(gulp.dest('public/css'))
        return this;
    };

    this.copy = function(src, dst) {
        gulp.src(config.basepath + src).pipe(gulp.dest(dst));
        return this;
    };
};

gulp.task('simplified', function(){
    return simplified.sass("scss/app.scss")
        .copy('vendor/jquery/jquery.min.js', 'public/js');
});

gulp.task('watch', function(){
    watch(config.basepath+"scss/*.scss").on('change', function(file){
        gulp.start('simplified');
    });
});

gulp.task('default', function () {
    gulp.start('simplified');
});
