import { task, src, dest, series, parallel, watch } from 'gulp';
import * as clean from 'gulp-clean';
import * as sass from 'gulp-sass';
import * as handlebars from 'gulp-compile-handlebars';
import * as rename from 'gulp-rename';
import * as dotenv from 'dotenv';

dotenv.config();

task('clean', () => src([
        './static/*.html',
        './static/css/*',
        './static/images/photoswipe/',
        './static/js/parallax.min.js',
    ], {allowEmpty: true})
    .pipe(clean()));

task('sass', () => src('./src/styles/*')
    .pipe(sass().on('error', sass.logError))
    .pipe(dest('./static/css')));

task('hbs', () => src(['./src/pages/*', '!./src/pages/partials'])
    .pipe(handlebars(process.env, { batch: './src/pages/partials' }))
    .pipe(rename({ extname: '.html' }))
    .pipe(dest('./static')));

task('photoswipe', () => src([
        './node_modules/photoswipe/dist/photoswipe-ui-default.min.js',
        './node_modules/photoswipe/dist/photoswipe.min.js',
        './node_modules/photoswipe/dist/photoswipe.css',
        './node_modules/photoswipe/dist/*default-skin/**/*',
    ])
    .pipe(dest('./static/images/photoswipe/')));

task('parallax', () => src('./node_modules/jquery-parallax.js/parallax.min.js')
    .pipe(dest('./static/js')))

task('default', series('clean', parallel('sass', 'hbs', 'photoswipe', 'parallax')));
  