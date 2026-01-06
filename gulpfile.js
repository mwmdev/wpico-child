const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const terser = require('gulp-terser');
const rename = require('gulp-rename');
const sourcemaps = require('gulp-sourcemaps');
const browserSync = require('browser-sync').create();
const wpPot = require('gulp-wp-pot');

// Configuration
const config = {
    proxyURL: 'localhost:8000', // Change this to match your local development URL
    textDomain: 'wpico-child',
    paths: {
        styles: {
            src: 'assets/sass/**/*.scss',
            dest: 'assets/css'
        },
        scripts: {
            src: 'assets/js/src/**/*.js',
            dest: 'assets/js'
        },
        php: '**/*.php',
        pot: {
            src: ['**/*.php', '!node_modules/**'],
            dest: 'languages'
        }
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

// POT file generation task for i18n
function pot() {
    return gulp.src(config.paths.pot.src)
        .pipe(wpPot({
            domain: config.textDomain,
            package: 'Wpico Child Theme',
            bugReport: 'https://github.com/wpico/wpico-child/issues',
            lastTranslator: 'Wpico Team',
            team: 'Wpico Team',
            headers: {
                'Report-Msgid-Bugs-To': 'https://github.com/wpico/wpico-child/issues',
                'Language-Team': 'LANGUAGE <LL@li.org>'
            }
        }))
        .pipe(gulp.dest(config.paths.pot.dest + '/' + config.textDomain + '.pot'));
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

// Build task (includes POT file generation)
const build = gulp.parallel(styles, scripts, pot);

// Default task
const dev = gulp.series(build, serve, watch);

exports.styles = styles;
exports.scripts = scripts;
exports.pot = pot;
exports.build = build;
exports.default = dev; 