<template>
  <v-container>
    <v-row class="justify-center">
      <v-col md="6" sm="12">
        <p class="body-1">
          2FA
        </p>
        <form @submit.prevent="submit">
          <v-card outlined>
            <Alert />
            <v-card-title>
              Step 1: Scan the QR code
            </v-card-title>
            <v-card-text>
              Scan the QR code below using your authenticator app.
            </v-card-text>
            <v-img :src="qrCode" aspect-ratio="1" contain max-height="300" />
            <v-col>
              <v-text-field
                v-model="twoFactor.string"
                disabled
                dense
                label="Can't Scan the QR Code?"
              />
            </v-col>
            <v-card-title>
              Step 2: Verify Authentication Code
            </v-card-title>
            <v-card-text>
              <v-text-field
                v-model="form.code"
                label="Code"
                outlined
                dense
                :class="{ 'is-invalid': pageHasError('code') }"
                class="form-control"
                name="code"
                :error="pageHasError('code') === true"
                :error-messages="getPageError('code')"
              />
            </v-card-text>
            <v-card-actions>
              <inertia-link class="v-btn v-btn--flat v-btn--text theme--light v-size--small primary--text" :href="route('settings')" method="get">
                Back to Settings
              </inertia-link>
              <v-spacer />
              <v-btn
                dark
                depressed
                :loading="loading"
                color="primary"
                type="submit"
              >
                Submit Code
              </v-btn>
            </v-card-actions>
          </v-card>
        </form>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import Layout from '~/layouts/Default'
import Alert from '~/components/Alert'
// import TwoFactorCreate from '~/components/Settings/TwoFactor/Create'

export default {
  metaInfo: { title: 'Settings' },

  layout: (h, page) => h(Layout, [page]),

  components: {
    Alert
  },

  props: {
    twoFactor: {
      type: Object,
      required: true
    }
  },

  data () {
    return {
      loading: false,
      form: {
        code: null
      },
    }
  },

  computed: {
    qrCode () {
      return 'data:image/svg+xml;base64,' + this.twoFactor.qrCode
    },
  },

  methods: {
    submit () {
      this.loading = true
      this.$inertia.post(this.route('settings.2fa.store'), this.form).then(() => this.loading = false)
    },
  },
}
</script>
