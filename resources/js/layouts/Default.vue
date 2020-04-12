<template>
  <v-app>
    <Sidebar
      :drawer="drawer"
    />

    <v-app-bar
      app
      color="primary"
      dark
      flat
      dense
      clipped-left
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
      <v-toolbar-title>
        <v-img tile contain max-height="45" max-width="45" :src="'/img/logo.png' | assetUrl" />
      </v-toolbar-title>
      <v-spacer />
      <v-toolbar-items>
        <v-btn icon>
          <v-icon size="24">
            notification_important
          </v-icon>
        </v-btn>
        <UserMenu />
      </v-toolbar-items>
    </v-app-bar>
    <v-content class="background">
      <v-container class="px-6 my-6" fluid>
        <flash-messages />
        <slot />
      </v-container>
    </v-content>
    <Footer />
  </v-app>
</template>

<script>
import Sidebar from '~/components/layout/Sidebar'
import Footer from '~/components/layout/Footer'
import UserMenu from '~/components/layout/UserMenu'

export default {
  name: 'MainLayout',
  components: {
    Sidebar,
    Footer,
    UserMenu
  },
  data: () => ({
    drawer: true
  }),
  methods: {
    //
  }
}
</script>
