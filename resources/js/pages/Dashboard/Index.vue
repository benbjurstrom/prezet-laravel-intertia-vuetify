<template>
  <v-container>
    <v-row class="justify-center">
      <v-col md="6" sm="12">
        //Dashboard.vue
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import Layout from '~/layouts/Default'

export default {
  metaInfo: { title: 'Dashboard' },

  layout: (h, page) => h(Layout, [page]),

  components: {
    //
  },

  props: {
    //
  },

  data: () => ({
    //
  }),
}
</script>
