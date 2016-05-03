
var config = require('./gulpconfig.json');

var gulp = require('gulp');
var browserSync = require('browser-sync').create();
var shell = require('gulp-shell');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var watch = require('gulp-watch');
var plumber = require('gulp-plumber');
var batch = require('gulp-batch');


gulp.task('default', ['serve']);


gulp.task('serve', ['twig', 'sass', 'lab-js', 'lab-sass', 'watch'], function() {

    browserSync.init({
        server: {
            baseDir: "output"
        },
        port: 8181,
        ghostMode: false,
        open: false,
        host: "172.123.123.123"
    });
    
});

gulp.task('build', ['twig', 'sass', 'lab-js', 'lab-sass']);

gulp.task('watch', function(){
    
    gulp.watch([
      'src/**/*.php',
      'html/**/*.twig',
      config.twig.rootDirectory + "/**/*.twig",
      config.twig.rootDirectory + "/**/*.yml",
      config.twig.rootDirectory + "/**/*.md"
    ], 
    batch(function (events, done) {
      gulp.start('twig', function () {
          browserSync.reload();
          done();
      })
    }))

    gulp.watch(config.scss.rootDirectory + "/**/*.scss", function() { gulp.start('sass'); });
    
    
    gulp.watch("scss/**/*.scss", batch(function(events, done){ 
        gulp.start('lab-sass', done) 
    }));
    
    
    gulp.watch("output/index.html", batch(function(events, done){
        browserSync.reload();
        done()
    }));
    
    
    gulp.watch(config.js.rootDirectory + "/**/*.js", function() { gulp.start('lab-js');browserSync.reload(); });

})


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
        .pipe(shell(['php -d xdebug.remote_enable=On -d xdebug.remote_host=172.123.123.1 src/generate.php \'' + JSON.stringify(config) + '\'']))
});


gulp.task('lab-js', function() {
    return gulp.src('', {read: false})
        .pipe(plumber())
        .pipe(shell('node_modules/.bin/browserify js/index.js -o output/lab/lab.js'))
});