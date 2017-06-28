/**
 * @file
 * Task: Compile: Styleguide.
 */

module.exports = function (gulp, plugins, options) {
  'use strict';
  gulp.task('compile:styleguide', function (cb) {
    gulp.src(options.styleGuide.assets)
    .pipe(plugins.rename(function (path) {
      path.dirname = '';
      return path;
    }))
    .pipe(gulp.dest(options.styleGuide.destination + '/assets'));
    plugins.kss(options.styleGuide, cb);
  });

};
