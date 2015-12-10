var gulp = require('gulp');  
var sass = require('gulp-sass');
var notify = require('gulp-notify');

gulp.task('default', function () {  
    gulp.src('./app/resources/scss/*.scss')
    .pipe(sass({
        includePaths: ['./app/resources/scss'],
		style: 'expanded'
    }))
    .pipe(gulp.dest('public/css'))
	.pipe(notify({message:"finished"}))
});
