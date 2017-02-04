/* eslint-disable */

const gulp = require('gulp');
const tasks = require('strt-gulptasks')({
  source: 'source',
  output: 'public/app/themes/starter/static'
});

gulp.task('default', gulp.series(
  tasks.clean,
  gulp.parallel(
    tasks.styles,
    tasks.scripts,
    tasks.images
  ),
  tasks.watch
));

gulp.task('production', gulp.series(
  gulp.parallel(
    tasks.styles,
    tasks.scripts,
    tasks.images
  )
));
