var gulp = require("gulp"),
    connect = require("gulp-connect"),
    opn = require("opn");
gulp.task('connect', function() {
  connect.server({
    root: 'www',
    livereload: true,
    port: 9999
  });
  opn('http://localhost:9999');
});

gulp.task('php', function () {
  gulp.src('./www/*.php')
    .pipe(connect.reload());
});

gulp.task('watch', function () {
  gulp.watch(['./www/*.php'], ['php']);
});

gulp.task('default', ['connect', 'watch']);