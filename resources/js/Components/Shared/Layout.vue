<template>
  <v-app id="inspire">
    <navigation-drawer />
    <app-bar />

    <v-content>
      <v-container fluid scroll-region>
        <flash-messages />
        <slot />
      </v-container>
    </v-content>
  </v-app>
</template>

<script>

export default {
  name: 'Layout',
  data () {
    return {
      showUserMenu: false,
      accounts: null,
    }
  },
  computed: {
  },
  methods: {
    url () {
      return location.pathname.substr(1)
    },
    hideDropdownMenus () {
      this.showUserMenu = false
    },
  },
}
</script>
