/* Paths */
const paths = {
  domain: "http://localhost:8888/villasia.loc",
  theme: "./",
  dist: "./assets/",
  src: "./sources/",
};

/* Imports */
// Plugins
import gulp from "gulp";
import plumber from "gulp-plumber";
import notify from "gulp-notify";
import rename from "gulp-rename";
import browsersync from "browser-sync";

// Reset
import { deleteAsync } from "del";

// Fonts
import ttf2woff2 from "gulp-ttf2woff2";

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
const fonts = () => {
  return gulp
    .src(paths.src + "fonts/*.ttf", {})
    .pipe(
      plumber(
        notify.onError({
          title: "FONTS",
          message: "Error: <%= error.message %>",
        })
      )
    )
    .pipe(ttf2woff2())
    .pipe(gulp.dest(paths.dist + "fonts/"));
};
const php = (done) => {
  browsersync.reload();
  done();
};
const scss = () => {
  const sass = gulpSass(dartSass);

  return gulp
    .src([paths.src + "scss/style.scss", paths.src + "scss/single/**/*.scss"], {
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
const svg = () => {
  return gulp
    .src(paths.src + "svg/**/*.svg")
    .pipe(
      plumber(
        notify.onError({
          title: "IMAGES",
          message: "Error: <%= error.message %>",
        })
      )
    )
    .pipe(gulp.dest(paths.dist + "svg/"))
    .pipe(browsersync.stream());
};
const libs = () => {
  return gulp
    .src(paths.src + "libs/**/*.*")
    .pipe(
      plumber(
        notify.onError({
          title: "FILES",
          message: "Error: <%= error.message %>",
        })
      )
    )
    .pipe(gulp.dest(paths.dist + "libs/"))
    .pipe(browsersync.stream());
};
const watcher = () => {
  gulp.watch(paths.theme + "**/*.php", php);
  gulp.watch(paths.src + "**/*.scss", scss);
  gulp.watch(paths.src + "**/*.js", js);
};
const server = (done) => {
  browsersync.init({
    proxy: paths.domain,
    // host: app.domain,
    // open: "external",
    // port: 3000,
    notify: true,
  });
};

/* Commands */
const tasks = gulp.series(reset, fonts, scss, js, svg, libs);

const dev = gulp.series(tasks, gulp.parallel(watcher, server));
const build = tasks;

gulp.task("dev", dev);
gulp.task("build", build);
gulp.task("fonts", fonts);
gulp.task("svg", svg);
gulp.task("libs", libs);
