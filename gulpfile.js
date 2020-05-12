var gulp = require('gulp');
var babel = require('gulp-babel');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');

gulp.task('scripts', function() {
    return gulp.src( [
        './assets/js/customize-controls.js'])
        .pipe(concat('customize-controls.js'))
        .pipe(babel({
            presets: ['@babel/env']
        }))
        .pipe( gulp.dest('./dist/js/') )
        .pipe( rename( { extname: '.min.js' } ) )
        .pipe( uglify() )
        .pipe( gulp.dest( './dist/js/' ) );
});


var sass = require('gulp-sass');
var postcss = require( 'gulp-postcss' );
var autoprefixer = require( 'autoprefixer' );
var cleanCSS = require( 'gulp-clean-css' );
var rename = require( 'gulp-rename' );

gulp.task( 'styles', function() {
    gulp.src( './Assets/scss/customize-controls.scss' )
      .pipe( sass() )
      .pipe( postcss([ autoprefixer() ]) )
      .pipe( gulp.dest( './dist/css/' ) )
      .pipe( rename( { extname: '.min.css' } ) )
      .pipe( cleanCSS() )
      .pipe( gulp.dest( './dist/css/' ) );
});


gulp.task( 'default', function() {
    gulp.watch( './Assets/scss/*.scss', ['styles'] );
    gulp.watch( './Assets/js/customize-controls.js', ['scripts'] );
});
