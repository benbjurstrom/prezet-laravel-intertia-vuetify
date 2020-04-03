import 'babel-polyfill'

import Vue from 'vue'
import VueMeta from 'vue-meta'
import PortalVue from 'portal-vue'
import { InertiaApp } from '@inertiajs/inertia-vue'
import vuetify from '~/plugins/vuetify'
import '~/plugins/fontawesome'
import '~/plugins/filters'

require('~/plugins/registerComponents')

Vue.config.productionTip = false
Vue.config.devtools = true

Vue.mixin({ methods: { route: window.route } })
Vue.use(InertiaApp)
Vue.use(PortalVue)
Vue.use(VueMeta)

const app = document.getElementById('app')

const eventBus = new Vue()
window.eventBus = eventBus

Vue.mixin({
  computed: {
    pageHasErrors: () => {
      return (Object.keys(Vue.prototype.$page.errors).length !== 0)
    },
  },
  methods: {
    pageHasError: (name) => {
      if (Object.keys(Vue.prototype.$page.errors).length === 0) return false
      return name in Vue.prototype.$page.errors
    },
    getPageError: (name) => {
      if (Object.keys(Vue.prototype.$page.errors).length === 0) return null
      return Vue.prototype.$page.errors[name]
    }
  }
})

window.App = new Vue({
  vuetify,

  metaInfo: {
    title: 'Loading...',
    titleTemplate: '%s • Vuetify Ping CRM',
    changed (info) {
      window.App.goBack = info.goBack
      window.App.appTitle = info.titleChunk
    }
  },

  data: vm => ({
    appTitle: 'Loading...',
    goBack: null,
    sideDrawer: null,
    flashSnackbar: false,
    flashMessage: '',
  }),

  mounted () {
    eventBus.$on('flashMessage', (value) => {
      this.flashMessage = value
      this.flashSnackbar = true
    })
  },

  render: h => h(InertiaApp, {
    props: {
      initialPage: JSON.parse(app.dataset.page),
      resolveComponent: name => import(`~/pages/${name}`).then(module => module.default),
      transformProps: props => {
        if (props.flash.success) {
          eventBus.$emit('flashMessage', props.flash.success)
        }
        return props
      },
    },
  }),
}).$mount(app)
