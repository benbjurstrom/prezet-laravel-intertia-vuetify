<template>
  <v-menu
    v-model="menu"
    :close-on-content-click="false"
    :nudge-width="170"
    offset-y
  >
    <template v-slot:activator="{ on }">
      <v-btn icon v-on="on">
        <v-avatar color="indigo" size="24">
          <v-img :src="gravatar" aspect-ratio="1" />
        </v-avatar>
      </v-btn>
    </template>

    <v-list>
      <v-list-item two-line>
        <v-list-item-avatar>
          <v-img :src="gravatar" aspect-ratio="1" />
        </v-list-item-avatar>
        <v-list-item-content>
          <v-list-item-title>
            {{ $page.auth.user.name }}
          </v-list-item-title>
          <v-list-item-subtitle>
            {{ $page.auth.user.email }}
          </v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
      <v-divider />
      <inertia-link class="v-list-item v-list-item--link theme--light" :href="route('settings')" replace @click="menu = false">
        <v-list-item-icon>
          <v-icon color="primary">
            settings
          </v-icon>
        </v-list-item-icon>
        <v-list-item-title>Settings</v-list-item-title>
      </inertia-link>
      <inertia-link class="v-list-item v-list-item--link theme--light" :href="route('auth.logout')" method="post" replace>
        <v-list-item-icon>
          <v-icon color="primary">
            exit_to_app
          </v-icon>
        </v-list-item-icon>
        <v-list-item-title>Logout</v-list-item-title>
      </inertia-link>
    </v-list>
  </v-menu>
</template>
<script>
export default {
  components: {
    //
  },
  props: {
    //
  },

  data: () => ({
    menu: false
  }),

  computed: {
    gravatar () {
      return 'https://www.gravatar.com/avatar/' + this.$page.auth.user.gravatar
    }
  },
  methods: {
    hasPermission () {
      return true
    }
  }
}
</script>
