// Include gulp
var gulp = require('gulp');

// Include Global Plugins
var plugins = require('gulp-load-plugins')({
  scope: ['devDependencies']
});

// Include Other Plugins
var browserSync = require('browser-sync');
var reload = browserSync.reload;

// Lint Task
gulp.task('lint', function() {
  return gulp.src('library/src/js/*.js')
    .pipe(plugins.jshint())
    .pipe(plugins.jshint.reporter('default'));
});

// Browser Sync Options
gulp.task('browser-sync', ['sass'], function() {
    browserSync.init({
      proxy: "http://localhost:8888/lucerne/",
      notify: false
    });
});

// Compile Our Sass
gulp.task('sass', function() {
  return gulp.src('library/src/sass/**/*.scss')
    .pipe(plugins.autoprefixer('last 2 versions'))
    .pipe(plugins.sourcemaps.init())
    .pipe(plugins.sass({outputStyle: 'compressed'}))
    .pipe(plugins.rename('style.min.css'))
    .pipe(plugins.sourcemaps.write())
    .pipe(plugins.sourcemaps.init({loadMaps: true}))
    .pipe(plugins.autoprefixer({browsers: ['last 2 versions']}))
    .pipe(plugins.sourcemaps.write('.'))
    .pipe(gulp.dest('library/dist/styles'))
    .pipe(browserSync.reload({stream: true}));
});

// Concatenate & Minify JS
gulp.task('scripts', function() {
  return gulp.src('library/src/js/*.js')
    .pipe(plugins.concat('all.js'))
    .pipe(gulp.dest('library/dist/js'))
    .pipe(plugins.rename('all.min.js'))
    .pipe(plugins.uglify())
    .pipe(gulp.dest('library/dist/js'))
    .pipe(browserSync.reload({stream: true}));
});

//Image Compression
gulp.task('images', function() {
    var imgSrc = 'library/src/img/*';
    var imgDest = 'library/dist/img';

  return gulp.src(imgSrc)
    .pipe(plugins.newer(imgDest))
    .pipe(plugins.imagemin())
    .pipe(gulp.dest(imgDest));

});

// Watch Files For Changes
gulp.task('watch', ['browser-sync'], function() {
  gulp.watch('library/src/js/*.js', ['lint', 'scripts']);
  gulp.watch('library/dist/js/*.js', ['lint', 'scripts']);
  gulp.watch('library/src/sass/**/*.scss', ['sass']);
  gulp.watch("**/*.php").on('change', browserSync.reload);
});


// Default Task
gulp.task('default', ['lint', 'sass', 'scripts', 'watch', 'browser-sync']);
