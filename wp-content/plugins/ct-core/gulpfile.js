/* Paths */

const paths = {
  domain: "http://localhost:8888/villasia.loc",
  main: "./",
  dist: "./assets/",
  src: "./sources/",
};

/* Imports */
// Plugins
import gulp from "gulp";
import plumber from "gulp-plumber";
import notify from "gulp-notify";
import browsersync from "browser-sync";
import rename from "gulp-rename";

// Reset
import { deleteAsync } from "del";

// SCSS
import dartSass from "sass";
import gulpSass from "gulp-sass";
import cssmin from "gulp-clean-css";
import autoprefixer from "gulp-autoprefixer";
import media from "gulp-group-css-media-queries";

// JS
import webpack from "webpack-stream";
import named from "vinyl-named";

/* Tasks */
const reset = () => {
  return deleteAsync(paths.dist);
};
const php = (done) => {
  browsersync.reload();
  done();
};
const scss = () => {
  const sass = gulpSass(dartSass);

  return gulp
    .src([paths.src + "scss/style.scss"], {
      sourcemaps: true,
    })
    .pipe(
      plumber(
        notify.onError({
          title: "SCSS",
          message: "Error: <%= error.message %>",
        })
      )
    )
    .pipe(
      sass({
        outputStyle: "expanded",
      })
    )
    .pipe(media())
    .pipe(
      autoprefixer({
        grid: true,
        overrideBrowserList: ["last 3 versions"],
        cascade: true,
      })
    )
    .pipe(gulp.dest(paths.dist + "css/")) // save normal css
    .pipe(cssmin({ level: 0 }))
    .pipe(
      rename({
        extname: ".min.css",
      })
    )
    .pipe(gulp.dest(paths.dist + "css/"))
    .pipe(browsersync.stream());
};
const js = () => {
  return (
    gulp
      .src(paths.src + "js/script.js", { sourcemaps: true })
      .pipe(
        plumber(
          notify.onError({
            title: "JS",
            message: "Error: <%= error.message %>",
          })
        )
      )

      // Save original js
      .pipe(named())
      .pipe(
        webpack({
          mode: "production",
          optimization: {
            minimize: false,
          },
        })
      )
      .pipe(gulp.dest(paths.dist + "js/"))

      // Production js
      .pipe(named())
      .pipe(
        webpack({
          mode: "production",
        })
      )
      .pipe(
        rename({
          extname: ".min.js",
        })
      )
      .pipe(gulp.dest(paths.dist + "js/"))
      .pipe(browsersync.stream())
  );
};
const files = () => {
  return gulp
    .src("./src/files/**/*.*")
    .pipe(
      plumber(
        notify.onError({
          title: "FILES",
          message: "Error: <%= error.message %>",
        })
      )
    )
    .pipe(gulp.dest("./assets/files/"))
    .pipe(browsersync.stream());
};
const server = (done) => {
  browsersync.init({
    proxy: `http://localhost:8888/villasia.loc`,
    // host: app.domain,
    // open: "external",
    // port: 3000,
    notify: true,
  });
};
const watcher = () => {
  gulp.watch(paths.main + "**/*.php", php);
  gulp.watch(paths.src + "scss/**/*.scss", scss);
  gulp.watch(paths.src + "js/**/*.js", js);
};

/* Commands */
const tasks = gulp.series(reset, scss, js, files);

const dev = gulp.series(tasks, gulp.parallel(watcher, server));
const build = tasks;

gulp.task("dev", dev);
gulp.task("build", build);
gulp.task("files", files);
