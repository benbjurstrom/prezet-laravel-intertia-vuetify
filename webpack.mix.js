const mix = require('laravel-mix')
const path = require('path')
const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin')
const ASSET_URL = (mix.inProduction() && process.env.ASSET_URL) ? process.env.ASSET_URL + '/' : '/'

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

if (!mix.inProduction()) {
  require('laravel-mix-versionhash')
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
    output: {
      publicPath: ASSET_URL
    },
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
