import { task, src, dest, series } from 'gulp';
import * as clean from 'gulp-clean';
import * as handlebars from 'gulp-compile-handlebars';
import * as rename from 'gulp-rename';

task('clean', () => src('./public/*.html')
    .pipe(clean()));

task('html', () => src('./src/pages/*')
    .pipe(handlebars({}, { batch: './src/partials' }))
    .pipe(rename({ extname: '.html' }))
    .pipe(dest('./public')));

task('default', series('clean', 'html'));
  