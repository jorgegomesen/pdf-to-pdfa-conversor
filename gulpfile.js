'use strict';

var gulp 		 = require('gulp'),
    uglify 		 = require('gulp-uglify'),
    concat 		 = require('gulp-concat'),
    cleanCSS     = require('gulp-clean-css'),
    sourcemaps   = require('gulp-sourcemaps'),
    autoprefixer = require('gulp-autoprefixer'),
    notify       = require('gulp-notify'),
    plumber      = require('gulp-plumber'),
    watch        = require('watch');

gulp.task('js', function () {
    return gulp.src(['./assets/js/src/jquery-3.2.1.js', './assets/js/src/*.js'])
        .pipe(plumber( {errorHandler: notify.onError("Error: <%= error.message %>")} ))
        .pipe(sourcemaps.init())
        // .pipe(uglify())
        .pipe(concat('main.min.js'))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('./assets/js/dist/'))
        .pipe(notify('Task JS finished!'));
});

gulp.task('css', function() {
    return gulp.src('./assets/css/src/*.css')
        .pipe(plumber( {errorHandler: notify.onError("Error: <%= error.message %>")} ))
        .pipe(autoprefixer())
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(concat('main.min.css'))
        .pipe(gulp.dest('./assets/css/dist/'))
        .pipe(notify('Task CSS finished!'));
});

gulp.task('watch', function() {
    gulp.watch('./assets/css/src/*.css', ['css']);
    gulp.watch('./assets/js/src/*.js', ['js']);
});

gulp.task('default', ['css', 'js', 'watch']);