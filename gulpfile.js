const gulp = require('gulp'), flowRemoveTypes = require('gulp-flow-remove-types'), rename = require('gulp-rename'),
    browserSync = require('browser-sync').create(), reload = browserSync.reload, settings = require('./settings'),
    launcher = require('launch-browser');

gulp.task('launcher', async function () {
    launcher(settings.urlToPreview, {browser: ['chrome']}, function (e, browser) {

        if (e) return console.log(e);

        browser.on('stop', function (code) {
            console.log('Browser closed with exit code:', code);
        });

    })
});

gulp.task('flow_remove_types', async function () {
    gulp.src('public/custom-assets/js/custom-src.js')
        .pipe(flowRemoveTypes({
            pretty: true
        }))
        .pipe(rename('custom.js'))
        .pipe(gulp.dest('public/custom-assets/js'));
});

gulp.task('flow_remove_types_dashboard.php', async function () {
    gulp.src('app/views/pages/src/dashboard.php')
        .pipe(flowRemoveTypes({
            pretty: true
        }))
        .pipe(rename('dashboard.php'))
        .pipe(gulp.dest('app/views/pages/'));
});

gulp.task('watch', async function () {
    browserSync.init({
        notify: false,
        proxy: settings.urlToPreview,
        ghostMode: false
    });
    gulp.watch('app/views/pages/src', gulp.series('flow_remove_types_dashboard.php')).on('change', reload);
    //gulp.watch('public/custom-assets/css/**/*.css').on('change', reload);
});

gulp.task('default', gulp.series('watch'));
