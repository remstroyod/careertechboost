const gulp = require('gulp'),
    watch = require('gulp-watch'),
    concat = require('gulp-concat'),
    sass = require('gulp-sass')(require('sass')),
    uglify = require('gulp-uglify'),
    cssmin = require('gulp-cssmin'),
    autoprefixer = require('gulp-autoprefixer'),
    sourcemaps = require('gulp-sourcemaps'),
    importCss = require('gulp-import-css'),
    browserSync = require('browser-sync').create(),
    pxtorem = require('gulp-pxtorem');

var config = {
    localUrl: "http://domain.local/"
};
try {
    config = require('./gulp.config')();
} catch (error) {
}
/**
 * Browser Sync
 */
gulp.task('serve', function () {
    browserSync.init({
        open: false,
        proxy: config.localUrl,
        notify: true,
        // https: {
        //     key: "/Applications/MAMP/Library/OpenSSL/certs/default.local.key",
        //     cert: "/Applications/MAMP/Library/OpenSSL/certs/default.local.crt"
        // }
    });
    gulp.watch(
        [
            'assets/scss/**/*.scss'
        ],
        gulp.parallel('css')
    );

    gulp.watch(
        [
            'assets/js/src/**/*.js',
            'assets/js/src/vendor/**/*.js',
            'assets/js/script/**/*.js',
            'assets/js/pages/**/*.js'
        ],
        gulp.parallel('js')
    );

    gulp.watch(
        [
            "./*.html"
        ]
    ).on('change', browserSync.reload);

    gulp.watch(
        [
            "./**/**/**/**/*.php"
        ]
    ).on('change', browserSync.reload);

});

/**
 * Compile CSS
 */
gulp.task('css', function () {
    return gulp.src('./assets/scss/main.scss')
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(sass().on('error', sass.logError))
        .pipe(importCss())
        .pipe(sass())
        .pipe(autoprefixer({
            overrideBrowserslist: ['last 2 versions'],
            cascade: false
        }))
        .pipe(pxtorem())
        .pipe(cssmin())
        .pipe(concat('bundle.css'))
        .pipe(sourcemaps.write('./', {
            includeContent: true,
            sourceRoot: '../../scss'
        }))
        .pipe(gulp.dest('./assets/css/'))
        .pipe(browserSync.reload({stream: true}))
});

/**
 * Compile JS
 */
gulp.task('js', function () {
    return gulp.src(
        [
            './assets/js/src/vendor/*.js',
            './assets/js/src/vendor/**/*.js',
            './assets/js/script/*.js',
            './assets/js/pages/*.js',
            './assets/js/pages/**/*.js',
        ]
    )
        .pipe(concat('bundle.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./assets/js/'))
        .pipe(browserSync.reload({stream: true}))

});

/**
 * Build
 */
gulp.task('build', gulp.series(['css', 'js']));
/**
 * Default
 */
gulp.task('default', gulp.series('serve'));
