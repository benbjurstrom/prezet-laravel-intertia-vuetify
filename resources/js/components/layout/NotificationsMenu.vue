<template>
  <v-menu
    v-model="menu"
    :close-on-content-click="false"
    :nudge-width="170"
    offset-y
  >
    <template v-slot:activator="{ on }">
      <v-btn icon v-on="on">
        <v-badge
          color="accent"
          :value="count"
          :content="count"
          class="theme--light"
          overlap
        >
          <v-icon size="24">
            notifications
          </v-icon>
        </v-badge>
      </v-btn>
    </template>

    <v-list min-width="300px">
      <v-list-item v-for="notification in notifications" :key="notification.id">
        <v-list-item-content>
          <v-list-item-title>{{ notification.data.title }}</v-list-item-title>
          <v-list-item-subtitle>{{ notification.data.body }}</v-list-item-subtitle>
        </v-list-item-content>
        <v-list-item-action class="subtitle-2 font-weight-light">
          {{ notification.data.created_at | distance }}
        </v-list-item-action>
      </v-list-item>
      <v-list-item v-if="!count">
        <v-card flat width="100%">
          <v-card-text class="text-center">
            <v-icon size="64">
              notifications_none
            </v-icon>
          </v-card-text>
          <v-card-text class="text-center">
            No Notifications
          </v-card-text>
        </v-card>
      </v-list-item>
      <v-divider />
      <inertia-link class="v-list-item v-list-item--link v-list-item--dense theme--light" :href="route('settings')" replace @click="menu = false">
        <v-list-item-icon>
          <v-icon color="primary">
            settings
          </v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>Notification Settings</v-list-item-title>
        </v-list-item-content>
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
    notifications () {
      return this.$page.notifications
    },
    count () {
      return this.$page.notifications.length
    }
  },

  mounted () {
    this.$echo.private('users.' + this.$page.auth.user.id).notification((notification) => {
      this.$page.notifications.push({ data: notification })
    })
  },

  methods: {
    hasPermission () {
      return true
    }
  }
}
</script>
<style>
  .theme--light .v-badge__badge {
    color: #666 !important;
  }
</style>
