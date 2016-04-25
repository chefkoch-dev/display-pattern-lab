
var pathToDisplayPatterns = 'vendor/chefkoch/display-patterns';

var gulp = require('gulp');
var browserSync = require('browser-sync').create();
var shell = require('gulp-shell');
var sass = require('gulp-sass');
var concat = require('gulp-concat');

gulp.task('serve', ['twig', 'sass'], function() {

    browserSync.init({
        server: {
            baseDir: "output"
        },
        port: 8080,
        ghostMode: false,
        open: "external"
    });

    gulp.watch(pathToDisplayPatterns + "/**/*.scss", ['sass']);
    gulp.watch(pathToDisplayPatterns + "/**/*.twig", ['twig']);
    gulp.watch(pathToDisplayPatterns + "/**/*.yml", ['twig']);
    gulp.watch("output/index.html").on('change', browserSync.reload);
});

gulp.task('sass', function() {
    return gulp.src(pathToDisplayPatterns + "/**/[^_]*.scss")
        .pipe(concat("styles.scss"))
        .pipe(sass({
            includePaths: pathToDisplayPatterns
        }))
        .pipe(gulp.dest("output/css"))
        .pipe(browserSync.stream());
});

gulp.task('twig', function() {
    return gulp.src('', {read: false})
        .pipe(shell(['php generate.php ' + pathToDisplayPatterns]))
});

gulp.task('default', ['serve']);
