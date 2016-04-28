
var config = require('./gulpconfig.json');

var gulp = require('gulp');
var browserSync = require('browser-sync').create();
var shell = require('gulp-shell');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var watch = require('gulp-watch');
var plumber = require('gulp-plumber');
var batch = require('gulp-batch');

gulp.task('serve', ['twig', 'sass', 'lab-sass'], function() {

    browserSync.init({
        server: {
            baseDir: "output"
        },
        port: 8080,
        ghostMode: false,
        open: false,
        host: "172.123.123.123"
    });

    for (var scssIncludePath in config.scss.includePaths) {
        watch(scssIncludePath + "/**/*.scss", function() { gulp.start('sass'); });
    }
    watch(
        [
            'generator/**/*.php',
            config.twig.rootDirectory + "/**/*.twig",
            config.twig.rootDirectory + "/**/*.yml"
        ],
        batch(function (events, done) {
            gulp.start('twig', done)
        })
    );

    watch("scss/**/*.scss", batch(function(events, done) { gulp.start('lab-sass', done) }));
    watch("output/index.html", batch(browserSync.reload));
});

gulp.task('lab-sass', function() {
    return gulp.src('scss/lab.scss')
        .pipe(plumber())
        .pipe(sass())
        .pipe(gulp.dest("output/lab"))
        .pipe(browserSync.stream());
});

gulp.task('sass', function() {
    return gulp.src(config.scss.indexFile)
        .pipe(plumber())
        .pipe(sass({
            includePaths: config.scss.includePaths
        }))
        .pipe(gulp.dest("output/css"))
        .pipe(browserSync.stream());
});

gulp.task('twig', function() {
    return gulp.src('', {read: false})
        .pipe(plumber())
        .pipe(shell(['php generator/generate.php \'' + JSON.stringify(config) + '\'']))
});

gulp.task('default', ['serve']);
