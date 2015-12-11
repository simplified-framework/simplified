var gulp = require('gulp');  
var sass = require('gulp-sass');
var notify = require('gulp-notify');

logError = function(err) {
    //console.log(err.message);
    notify({message:err.message,title:"Error",wait:true});
}

gulp.task('default', function () {  
    gulp.src('./app/resources/scss/app.scss')
    .pipe(sass().on('error', notify.onError(function(error){
        return {message:error.message,title:"Error running SASS"};
    })))
    .pipe(gulp.dest('public/css'))
	.pipe(notify({title:"Running SASS", message:"finished"}))
});
