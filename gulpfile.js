
var config = require('./gulpconfig.json');

var gulp = require('gulp');
var browserSync = require('browser-sync').create();
var shell = require('gulp-shell');
var sass = require('gulp-sass');
var concat = require('gulp-concat');

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
        gulp.watch(scssIncludePath + "/**/*.scss", ['sass']);
    }
    gulp.watch(config.twig.rootDirectory + "/**/*.twig", ['twig']);
    gulp.watch(config.twig.rootDirectory + "/**/*.yml", ['twig']);
    gulp.watch("scss/**/*.scss", ['lab-sass']);
    gulp.watch("output/index.html").on('change', browserSync.reload);
});

gulp.task('lab-sass', function() {
    return gulp.src('scss/lab.scss')
        .pipe(sass())
        .pipe(gulp.dest("output/lab"))
        .pipe(browserSync.stream());
});

gulp.task('sass', function() {
    return gulp.src(config.scss.indexFile)
        .pipe(sass({
            includePaths: config.scss.includePaths
        }))
        .pipe(gulp.dest("output/css"))
        .pipe(browserSync.stream());
});

gulp.task('twig', function() {
    return gulp.src('', {read: false})
        .pipe(shell(['php generate.php \'' + JSON.stringify(config) + '\'']))
});

gulp.task('default', ['serve']);
