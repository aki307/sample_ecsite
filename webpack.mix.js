// let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix.js('resources/assets/js/app.js', 'public/js')
//   .sass('resources/assets/sass/app.scss', 'public/css');

// テスト↓

// const glob = require('glob');

// sassディレクトリ直下のscssファイルを全てコンパイル
// glob.sync('resources/assets/sass/*.scss').map(function(file) {
//   mix.sass(file, 'public/assets/css');
// });

// jsファイルを連結・圧縮
// mix.scripts(glob.sync('resources/assets/js/modules/vendors/*.js'), 'public/assets/js/vendors.js');

// const mix = require('laravel-mix');
//     mix.setResourceRoot('');
//     mix.sass('resources/sass/welcome.scss', 'public/css/');

let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix.js('resources/assets/js/app.js', 'public/js')
//    .sass('resources/assets/sass/welcome.scss', 'public/assets/css');

const glob = require('glob');

// 外部ライブラリを読み込み
let cssFiles = glob.sync('public/assets/css/vendors/*.css');

// sassディレクトリ直下のscssファイルを全てコンパイルし、バンドル対象に追加
glob.sync('resources/assets/sass/*.scss').map(function(file) {

  // コンパイル
  mix.sass(file, 'public/assets/css');

  // コンパイル後のパスを作成
  let filename = file.split('/');
  filename = filename[filename.length-1];
  
  // バンドル対象に追加
  cssFiles.push('public/assets/css/' + filename.replace('.scss','.css'));
});

// mix.styles([
//  'public/assets/css/skeleton.css',
//  'public/assets/css/welcome.css'], 'public/css/all.css');

console.log(cssFiles);

// StyleSheetをバンドル
mix.styles(cssFiles, 'public/css/all.css');  
  
  

// mix.js('resources/assets/js/index.js', 'public/js');

mix.js('resources/assets/js/app.js', 'public/js');
mix.scripts('resources/assets/js/test.js', 'public/js/test.js');