<template>
  <v-app>
    <Sidebar
      :drawer="drawer"
    />

    <v-app-bar
      clipped-left
      app
      color="white"
    >
      <v-card flat style="margin: -16px;" tile height="64" width="256" color="white" class="d-flex justify-center align-center">
        <v-toolbar-title @click.stop="drawer = !drawer">
          LOGO <!--<v-img tile height="45" width="232" :src="'' | assetUrl" />-->
        </v-toolbar-title>
      </v-card>
      <v-spacer />
      <inertia-link class="v-btn v-btn--flat v-btn--text theme--light v-size--default" :href="route('logout')" method="post">
        Logout
      </inertia-link>
    </v-app-bar>

    <v-content class="mx-4 my-6">
      <v-container fluid>
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

export default {
  name: 'MainLayout',
  components: {
    Sidebar,
    Footer
  },
  data: () => ({
    drawer: true
  }),
  methods: {
    //
  }
}
</script>
