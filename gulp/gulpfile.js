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
gulp.task('build-font', function(){
    return gulp.src('../app/Resources/assets/icons/*.svg')
        .pipe(iconfontCss({
                fontName: 'app',
                path: '../app/Resources/less/font/template.less',
                targetPath: '../../../app/Resources/less/app/font.less',
                fontPath: '/dist/fonts/'
            }))
        .pipe(iconfont({
            fontName: 'app',
            formats: ['ttf', 'eot', 'woff', 'woff2', 'svg'],
            normalize: true
        }))
        .pipe(gulp.dest('../web/dist/fonts/'));
});

/*gulp.task('build-ifont-css', function () {
    return gulp.src('../app/Resources/less/app/font.less')
        .pipe(base64({
            baseDir: '../web/',
            maxImageSize: 100 * 1024
        }))
        .pipe(concat('font.less'))
        .pipe(gulp.dest('../app/Resources/less/app/'));
});*/

gulp.task('build-styles-front', function() {
    return gulp.src([
        '../app/Resources/less/bootstrap/bootstrap.less',
        '../app/Resources/less/bootstrap/theme.less',
        '../app/Resources/less/app/*.less',
        '../app/Resources/assets/**/*.css',
        '../app/Resources/less/front.less'
    ])
        .pipe(less())
        .pipe(concatCss('front.css'))
        .pipe(cssnano({
            discardComments: {
                removeAll: true
            }
        }))
        .pipe(gulp.dest('../web/dist'));
});

gulp.task('build-styles-user', function() {
    return gulp.src([
            '../app/Resources/less/bootstrap/bootstrap.less',
            '../app/Resources/less/bootstrap/theme.less',
            '../app/Resources/less/admin-lte/AdminLTE.less',
            '../app/Resources/less/admin-lte/skins/skin-purple.less',
            '../app/Resources/less/app/*.less',
            '../app/Resources/assets/**/*.css',
            '../app/Resources/less/user.less'
        ])
        .pipe(less())
        .pipe(concatCss('user.css'))
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
            '../app/Resources/less/admin-lte/skins/skin-green.less',
            '../app/Resources/less/app/*.less',
            '../app/Resources/assets/**/*.css',
            '../app/Resources/less/admin.less'
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
    return gulp.src(['../app/Resources/assets/**/*.js'])
        .pipe(concat('script.js'))
        .pipe(uglify())
        .pipe(gulp.dest('../web/dist'));
});

// default tasks
gulp.task('default', function (callback) {
    runSequence('clean', ['build-font', 'build-scripts'], ['build-styles-front', 'build-styles-user', 'build-styles-admin'], callback);
});