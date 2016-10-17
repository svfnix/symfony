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
    del.sync('../web/dist/*', {force: true});
});

// build tasks
gulp.task('build-ifont', function(){
    return gulp.src('../app/Resources/ifont/*.svg')
        .pipe(iconfontCss({
                fontName: 'ifont',
                path: '../app/Resources/less/ifont/templates/ifont.less',
                targetPath: '../ifont.less',
                fontPath: './fonts/'
            }))
        .pipe(iconfont({
            fontName: 'ifont',
            formats: ['ttf', 'eot', 'woff', 'woff2', 'svg'],
            normalize: true
        }))
        .pipe(gulp.dest('../app/Resources/less/ifont/fonts/'));
});

gulp.task('build-ifont-css', function () {
    return gulp.src('../app/Resources/less/ifont/ifont.less')
        .pipe(base64({
            baseDir: '../app/Resources/less/ifont/',
            maxImageSize: 100 * 1024
        }))
        .pipe(concat('ifont.less'))
        .pipe(gulp.dest('../app/Resources/less/'));
});

gulp.task('build-styles-front', function() {
    return gulp.src([
        '../app/Resources/less/bootstrap/bootstrap.less',
        '../app/Resources/less/bootstrap/theme.less',
        '../app/Resources/less/*.less',
        '../app/Resources/assets/*.css',
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

gulp.task('build-styles-admin', function() {
    return gulp.src([
        '../app/Resources/less/bootstrap/bootstrap.less',
        '../app/Resources/less/bootstrap/theme.less',
        '../app/Resources/less/admin-lte/AdminLTE.less',
        '../app/Resources/less/admin-lte/skins/skin-purple.less',
        '../app/Resources/less/*.less',
        '../app/Resources/assets/*.css'
    ])
        .pipe(less())
        .pipe(concatCss('admin.css'))
        .pipe(cssnano({
            discardComments: {
                removeAll: true
            }
        }))
        .pipe(gulp.dest('../web/dist'));
});

gulp.task('build-scripts', function() {
    return gulp.src(['../app/Resources/assets/*.js'])
        .pipe(concat('script.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../web/dist'));
});

// default tasks
gulp.task('default', function (callback) {
    runSequence('clean', 'build-ifont', 'build-ifont-css', ['build-styles-front', 'build-styles-admin', 'build-scripts'], callback);
});