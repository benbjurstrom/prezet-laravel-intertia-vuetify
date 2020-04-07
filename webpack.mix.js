require('laravel-mix-versionhash')
require('laravel-mix-purgecss')
const mix = require('laravel-mix')
const path = require('path')
const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin')
const ASSET_URL = (mix.inProduction()) ? process.env.ASSET_URL + '/' : '/'

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

mix.js('resources/js/app.js', 'public/js')
  .sass('resources/sass/app.sass', 'public/css')
  .options({
    processCssUrls: false
  })
  .disableNotifications()

if (mix.inProduction()) {
  mix
    .purgeCss()
  // .extract() // Disabled until resolved: https://github.com/JeffreyWay/laravel-mix/issues/1889
} else {
  mix.sourceMaps()
    .versionHash()
}

mix.webpackConfig(webpack => {
  return {
    plugins: [
      new VuetifyLoaderPlugin(),
      new webpack.DefinePlugin({
        'process.env.ASSET_PATH': JSON.stringify(ASSET_URL)
      })
    ],
    output: { chunkFilename: 'js/[name].js?id=[chunkhash]' },
    resolve: {
      alias: {
        vue$: 'vue/dist/vue.runtime.esm.js',
        '~': path.resolve('resources/js'),
      },
    },
    module: {
      rules: [
        {
          enforce: 'pre',
          test: /\.(js|vue)$/,
          loader: 'eslint-loader',
          exclude: /(node_modules)/,
          options: {
            configFile: 'quality/.eslintrc.js',
            emitError: true,
            emitWarning: true,
            failOnError: true,
            failOnWarning: true,
            fix: true,
          }
        }
      ]
    }
  }
})

mix.babelConfig({
  plugins: ['@babel/plugin-syntax-dynamic-import'],
})
