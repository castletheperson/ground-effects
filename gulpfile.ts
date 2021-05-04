import { task, src, dest, series, parallel, watch } from 'gulp';
import * as clean from 'gulp-clean';
import * as sass from 'gulp-sass';
import * as handlebars from 'gulp-compile-handlebars';
import * as rename from 'gulp-rename';

task('clean', () => src(['./static/*.html', './static/css/*'])
    .pipe(clean()));

task('sass', () => src('./src/styles/*')
    .pipe(sass().on('error', sass.logError))
    .pipe(dest('./static/css')));

task('hbs', () => src('./src/pages/*')
    .pipe(handlebars({}, { batch: './src/pages/partials' }))
    .pipe(rename({ extname: '.html' }))
    .pipe(dest('./static')));

task('default', series('clean', parallel('sass', 'hbs')));
  