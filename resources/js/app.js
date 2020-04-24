import 'babel-polyfill'

import Vue from 'vue'
import VueMeta from 'vue-meta'
import PortalVue from 'portal-vue'
import { InertiaApp } from '@inertiajs/inertia-vue'
import vuetify from '~/plugins/vuetify'
import '~/plugins/fontawesome'
import '~/plugins/filters'
import Pusher from 'pusher-js'
import VueEcho from 'vue-echo'

require('~/plugins/registerComponents')

Vue.config.productionTip = false
Vue.config.devtools = true

Vue.mixin({ methods: { route: window.route } })
Vue.use(InertiaApp)
Vue.use(PortalVue)
Vue.use(VueMeta)

const app = document.getElementById('app')
const page = JSON.parse(app.dataset.page)

window.Pusher = Pusher
Vue.use(VueEcho, {
  broadcaster: 'pusher',
  key: page.props.config.pusherKey,
  cluster: 'us3',
  auth: {
    headers: {
      'X-CSRF-TOKEN': page.props.config.csrfToken,
    },
  }
})

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
    titleTemplate: '%s • Prezet',
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
      initialPage: page,
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
