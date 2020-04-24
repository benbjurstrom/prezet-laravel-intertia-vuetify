<template>
  <v-container>
    <v-row class="justify-center">
      <v-col md="6" sm="12">
        <p class="body-1">
          Notification Demo
        </p>
        <NotificationsDemo />
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import Layout from '~/layouts/Default'
import NotificationsDemo from '~/components/Demo/CreateNotification'

export default {
  metaInfo: { title: 'Dashboard' },

  layout: (h, page) => h(Layout, [page]),

  components: {
    NotificationsDemo
  },

  props: {
    //
  },

  data: () => ({
    //
  }),
}
</script>
