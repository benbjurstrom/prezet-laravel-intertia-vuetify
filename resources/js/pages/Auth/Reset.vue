<template>
  <v-row
    align="center"
    justify="center"
    class="ma-0"
  >
    <v-col
      cols="12"
      sm="8"
      md="4"
      lg="4"
      xl="3"
    >
      <v-row
        align="center"
        justify="center"
      >
        <v-col class="my-4">
          <v-img
            :max-height="120"
            src="/img/logo.png"
            contain
          />
        </v-col>
      </v-row>
      <v-card outlined>
        <Alert />
        <Reset
          :user-id="userId"
          :token="token"
        />
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import Layout from '~/layouts/Basic'
import Reset from '~/components/auth/Reset'
import Alert from '~/components/Alert'

export default {
  metaInfo: { title: 'Reset Password' },
  layout: (h, page) => h(Layout, [page]),
  components: {
    Reset,
    Alert
  },

  props: {
    userId: {
      type: String,
      required: true,
    },
    token: {
      type: String,
      required: true,
    },
  },

  data () {
    return {
      //
    }
  },

  methods: {
    //
  },
}
</script>
