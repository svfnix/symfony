var gulp = require('gulp');
var del = require('del');
var less = require('gulp-less');
var uglify = require('gulp-uglify');
var cssnano = require('gulp-cssnano');
var concat= require('gulp-concat');
var concatCss = require('gulp-concat-css');
var iconfont = require('gulp-iconfont');
var iconfontCss = require('gulp-iconfont-css');
var base64 = require('gulp-base64');
var runSequence = require('run-sequence');

// cleaning the stage
gulp.task('clean', function(){
    del.sync('css/*');
    del.sync('js/*');
    del.sync('../web/dist/*', {force: true});
});

// build tasks
gulp.task('build-fonts', function(){
    return gulp.src('../app/Resources/font/*.svg')
        .pipe(iconfontCss({
                fontName: 'ifont',
                path: '../app/Resources/templates/ifont.less',
                fontPath: '/css/fonts/',
                targetPath: '../app/Resources/build/ifont.less'
            }))
        .pipe(iconfont({
            fontName: 'ifont',
            normalize: true
        }))
        .pipe(gulp.dest('../app/Resources/build/fonts/'));
});

gulp.task('build-fonts-css', function () {
    return gulp.src('../app/Resources/build/ifont.less')
        .pipe(base64({
            baseDir: '../app/Resources/build/fonts/',
            maxImageSize: 40*1024
        }))
        .pipe(concat('ifont.less'))
        .pipe(gulp.dest('../app/Resources/less/'));
});

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
        .pipe(gulp.dest('../web/dist'));
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