import Vue from 'vue'
import { format } from 'date-fns'

Vue.filter('localDateTime', (val) => {
  if (!val) return ''
  return format(new Date(val), 'MM/DD/YYYY hh:mm:ss a')
})

Vue.filter('assetUrl', function (url) {
  if (!Vue.prototype.$page.config.assetUrl) {
    return url
  }

  return Vue.prototype.$page.config.assetUrl + url
})
