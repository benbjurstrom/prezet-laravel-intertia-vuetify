import Vue from 'vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import {
  faCog,
  faExternalLinkAlt,
  faHome
} from '@fortawesome/free-solid-svg-icons'

// import {
//   faGithub
// } from '@fortawesome/free-brands-svg-icons'

library.add(
  faCog,
  faExternalLinkAlt,
  faHome
)

Vue.component('fa', FontAwesomeIcon)
