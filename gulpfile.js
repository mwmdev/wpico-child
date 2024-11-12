const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const terser = require('gulp-terser');
const rename = require('gulp-rename');
const sourcemaps = require('gulp-sourcemaps');
const browserSync = require('browser-sync').create();

// Configuration
const config = {
    proxyURL: 'localhost:8000', // Change this to match your local development URL
    paths: {
        styles: {
            src: 'assets/sass/**/*.scss',
            dest: 'assets/css'
        },
        scripts: {
            src: 'assets/js/src/**/*.js',
            dest: 'assets/js'
        },
        php: '**/*.php'
    }
};

// Styles task
function styles() {
    return gulp.src(config.paths.styles.src)
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(cleanCSS())
        .pipe(rename({ suffix: '.min' }))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(config.paths.styles.dest))
        .pipe(browserSync.stream());
}

// Scripts task
function scripts() {
    return gulp.src(config.paths.scripts.src)
        .pipe(sourcemaps.init())
        .pipe(terser())
        .pipe(rename({ suffix: '.min' }))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(config.paths.scripts.dest))
        .pipe(browserSync.stream());
}

// BrowserSync
function serve(done) {
    browserSync.init({
        proxy: config.proxyURL,
        open: false
    });
    done();
}

// Watch task
function watch() {
    gulp.watch(config.paths.styles.src, styles);
    gulp.watch(config.paths.scripts.src, scripts);
    gulp.watch(config.paths.php).on('change', browserSync.reload);
}

// Build task
const build = gulp.parallel(styles, scripts);

// Default task
const dev = gulp.series(build, serve, watch);

exports.styles = styles;
exports.scripts = scripts;
exports.build = build;
exports.default = dev; 