import Vue from 'vue'
import { format } from 'date-fns'

Vue.filter('localDateTime', (val) => {
  if (!val) return ''
  return format(new Date(val), 'MM/DD/YYYY hh:mm:ss a')
})

Vue.filter('assetUrl', function (url) {
  // if (!this.$page.assetUrl) {
  return url
  // }

  // return window.config.assetUrl + url
})
