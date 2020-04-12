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
            :src="'/img/logo.png' | assetUrl"
            contain
          />
        </v-col>
      </v-row>
      <v-card outlined>
        <v-tabs
          v-model="tab"
          fixed-tabs
        >
          <v-tab>
            Login
          </v-tab>
          <v-tab>
            Sign Up
          </v-tab>
        </v-tabs>
        <Alert />
        <v-tabs-items v-model="tab">
          <v-tab-item>
            <Login />
          </v-tab-item>
          <v-tab-item>
            <Register />
          </v-tab-item>
        </v-tabs-items>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import Layout from '~/layouts/Basic'
import Login from '~/components/auth/Login'
import Register from '~/components/auth/Register'
import Alert from '~/components/Alert'

export default {
  metaInfo: { title: 'Login' },
  layout: (h, page) => h(Layout, [page]),
  components: {
    Login,
    Register,
    Alert
  },
  data () {
    return {
      tab: null,
    }
  },
  methods: {
    //
  },
}
</script>
