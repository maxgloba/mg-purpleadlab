var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var csso = require('gulp-csso');
var rename = require("gulp-rename");
var browserSync = require('browser-sync');
var plumber = require('gulp-plumber');

gulp.task('build', function() {
    return gulp.src('../sass/*.scss')
        .pipe(plumber())
        .pipe (sass())
        .pipe(autoprefixer({
            browsers: ['last 10 versions']
        }))
        .pipe(csso())
        .pipe(rename({
            extname: '.css',
            suffix: '.min'
        }))
        .pipe(gulp.dest('../dist/'))
        .pipe(browserSync.stream())
});

gulp.task('browser-sync', function() {
    browserSync({
        server: {
            baseDir: '../'
        },
        notify: false
    })
})

gulp.task('watch', ['browser-sync', 'build'], function() {
    gulp.watch('../sass/*.scss', ['build'])
    gulp.watch('*html', browserSync.reload)
})