var gulp = require('gulp');
var del = require('del');
var less = require('gulp-less');
var uglify = require('gulp-uglify');
var cssnano = require('gulp-cssnano');
var concat= require('gulp-concat');
var concatCss = require('gulp-concat-css');
var runSequence = require('run-sequence');

// cleaning the stage
gulp.task('clean', function(){
    return del.sync('css/*');
    return del.sync('js/*');
    return del.sync('../web/dist/*', {force: true});
});

// build tasks
gulp.task('build-less', function() {
    return gulp.src([
        '../app/Resources/less/bootstrap/bootstrap.less',
        '../app/Resources/less/bootstrap/theme.less',
        '../app/Resources/less/*.less',
        '../src/**/*.less'
        ])
        .pipe(less())
        .pipe(concatCss('style.css'))
        .pipe(cssnano({
            discardComments: {
                removeAll: true
            }
        }))
        .pipe(gulp.dest('../web/dist'))
});

gulp.task('build-js', function() {
    return gulp.src(['../app/Resources/js/*.js', '../src/**/*.js'])
        .pipe(concat('script.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../web/dist'));
});

// default tasks
gulp.task('default', function (callback) {
    runSequence('clean', ['build-less', 'build-js'], callback);
});