import { src, dest, series, parallel } from 'gulp';
import del from 'del';
const sass = require('gulp-sass')(require('sass'));
const handlebars = require('gulp-compile-handlebars');
import run from 'gulp-run-command';
import rename from 'gulp-rename';
import dotenv from 'dotenv';
dotenv.config();

export const clean = () => del([
    './static/*.html',
    './static/css',
    './static/images/photoswipe',
    './static/js',
]);

export const scss = () => src('./src/styles/*')
    .pipe(sass().on('error', sass.logError))
    .pipe(dest('./static/css'));

export const hbs = () => src(['./src/pages/*', '!./src/pages/partials'])
    .pipe(handlebars(process.env, { batch: './src/pages/partials' }))
    .pipe(rename({ extname: '.html' }))
    .pipe(dest('./static'));

export const photoswipe = () => src([
        './node_modules/photoswipe/dist/photoswipe-ui-default.min.js',
        './node_modules/photoswipe/dist/photoswipe.min.js',
        './node_modules/photoswipe/dist/photoswipe.css',
        './node_modules/photoswipe/dist/*default-skin/**/*',
    ])
    .pipe(dest('./static/images/photoswipe/'));

export const parallax = () => src('./node_modules/jquery-parallax.js/parallax.min.js')
    .pipe(dest('./static/js'));

export const ts = run('tsc');

export default series(
    clean,
    parallel(scss, hbs, photoswipe, parallax, ts)
);
  