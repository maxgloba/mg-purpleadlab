'use strict';

var
	gulp = require('gulp'),
	sass = require('gulp-sass'),
	autoprefixer = require('gulp-autoprefixer'),
	htmlmin = require('gulp-htmlmin'),
	imagemin = require('gulp-imagemin'),
	pngquant = require('imagemin-pngquant'),
	clean = require('gulp-clean'),
	browserSync = require('browser-sync').create(),
	rigger = require('gulp-rigger');


sass.compiler = require('node-sass');

gulp.task('sass', function () {
	return gulp.src('dev/scss/**/*.scss')
		.pipe(sass.sync({outputStyle: 'uncompressed'})
		.on('error', sass.logError))
		.pipe(autoprefixer({
			browsers: ['last 2 versions'],
			cascade: false
		}))
		.pipe(gulp.dest('live/css'))
		.pipe(browserSync.reload({stream: true}));
});

gulp.task('html', function() {
	return gulp.src('dev/*.html')
		.pipe(rigger())
		.pipe(htmlmin({collapseWhitespace: false}))
		.pipe(gulp.dest('live'))
		.pipe(browserSync.reload({stream: true}));
});

gulp.task('images', function () {
	return gulp.src('dev/img/**')
		.pipe(imagemin({
			progressive: true,
			svgoPlugins: [{removeViewBox: false}],
			use: [pngquant()],
			interlaced: true
		}))
		.pipe(gulp.dest('live/img'))
		.pipe(browserSync.reload({stream: true}));
});

gulp.task('js', function(){
	return gulp.src('dev/js/**/*.js')
		.pipe(rigger())
		.pipe(gulp.dest('live/js'))
		.pipe(browserSync.reload({stream: true}));
});

gulp.task('browser-sync', function() {
    browserSync.init({
        server: {
            baseDir: "live"
        },
        notify: false
    });
});

gulp.task('default', ['browser-sync', 'sass', 'html', 'images', 'js'], function () {
	gulp.watch('dev/scss/**/*.scss', ['sass']);
	gulp.watch('dev/**/*.html', ['html']);
	gulp.watch('dev/img/**', ['images']);
	gulp.watch('dev/js/**/*.js', ['js']);
});

gulp.task('clean', function () {
	return gulp.src('live/')
		.pipe(clean());
});

// gulp.task('default', ['clean', 'watch']);

//Консольные команды
//gulp watch - следит за изменениями в файлах
//gulp clean - очищает папку live