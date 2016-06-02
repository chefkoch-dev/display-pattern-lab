
var config = require('./gulpconfig.json');

var gulp = require('gulp');
var postcss = require('gulp-postcss');
var autoprefixer = require('autoprefixer');
var browserSync = require('browser-sync').create();
var shell = require('gulp-shell');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var watch = require('gulp-watch');
var plumber = require('gulp-plumber');
var batch = require('gulp-batch');
var modernizr = require('gulp-modernizr');


gulp.task('default', ['serve']);


gulp.task('serve', ['build', 'watch'], function() {

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


gulp.task('build', ['modernizr', 'twig', 'sass', 'lab-js', 'lab-js-vendor', 'lab-sass', 'assets']);


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
    }));

    gulp.watch(config.scss.rootDirectory + "/**/*.scss", function() { gulp.start('sass'); });
    
    
    gulp.watch("scss/**/*.scss", batch(function(events, done){ 
        gulp.start('lab-sass', done) 
    }));
    
    
    gulp.watch("output/index.html", batch(function(events, done){
        browserSync.reload();
        done()
    }));
    
    
    gulp.watch(config.js.rootDirectory + "/**/*.js", function() { gulp.start('lab-js');browserSync.reload(); });

});


gulp.task('lab-sass', function() {
    return gulp.src('scss/lab.scss')
        .pipe(plumber())
        .pipe(sass())
        .pipe(gulp.dest("output/lab"))
        .pipe(browserSync.stream());
});


gulp.task('sass', function() {
    var processors = [
        autoprefixer({browsers: ['last 3 versions']})
    ];
    return gulp.src([config.scss.rootDirectory + "/**/*.scss", config.scss.indexFile])
        .pipe(plumber())
        .pipe(sass({
            includePaths: config.scss.includePaths,
            outputStyle: "compact"
        }))
        .pipe(postcss(processors))
        .pipe(gulp.dest("output/css"))
        .pipe(browserSync.stream());
});


gulp.task('twig', function() {
    return gulp.src('', {read: false})
        .pipe(plumber())
        .pipe(shell(['php -d xdebug.remote_enable=On -d xdebug.remote_host=172.123.123.1 src/generate.php \'' + JSON.stringify(config) + '\'']))
});


gulp.task('assets', function () {
    return gulp.src('vendor/chefkoch/display-patterns/assets/**/*', {
    }).pipe(gulp.dest('output/assets'));
});


gulp.task('lab-js', function() {
    return gulp.src('', {read: false})
        .pipe(plumber())
        .pipe(shell('node_modules/.bin/browserify js/index.js -o output/lab/lab.js'))
});

gulp.task('lab-js-vendor', function() {
    return gulp.src('js/vendor/**/*', {
    }).pipe(gulp.dest('output/lab/vendor'));
});

gulp.task('postcss', function () {
    var processors = [
        autoprefixer({browsers: ['last 3 versions']}),
    ];
    return gulp.src("output/css")
        .pipe(postcss(processors))
        .pipe(gulp.dest('./dest'));
});

// Task: Build a customized modernizr build based on used tests
// (customizr crawls the Sass and JS files and checks for usages, i.e. .no-svg { … })
gulp.task('modernizr', function() {
    return gulp.src(config.modernizr.files)
        .pipe(modernizr())
        .pipe(gulp.dest(config.modernizr.dest));
});