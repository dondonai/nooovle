var gulp = require('gulp');
var compass = require('gulp-compass'),
  minifyCSS = require('gulp-minify-css'),
  plumber = require('gulp-plumber');
 
gulp.task('compass', function() {
  gulp.src('sass/*.scss')
    .pipe(plumber({
      errorHandler: function (error) {
        console.log(error.message);
        this.emit('end');
    }}))
    .pipe(compass({
      css: '',
      sass: 'sass',
      image: 'images'
    }))
    .pipe(minifyCSS())
    .pipe(gulp.dest('assets/temp'));
});

gulp.task('watch', function() {
  gulp.watch('sass/*.scss',  ['compass']);
});

gulp.task('default', ['watch']);