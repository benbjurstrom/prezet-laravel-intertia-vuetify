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
      <p class="body-1">
        2FA
      </p>
      <v-card outlined>
        <Alert />
        <form @submit.prevent="submit">
          <v-container>
            <v-card-text>
              Enter your 2FA Code To Continue
            </v-card-text>
            <v-card-text>
              <v-text-field
                v-model="form.code"
                label="2FA Code"
                outlined
                :class="{ 'is-invalid': pageHasError('code') }"
                class="form-control"
                name="code"
                :error="pageHasError('code') === true"
                :error-messages="getPageError('code')"
              />
            </v-card-text>
            <v-card-actions>
              <v-spacer />
              <v-btn
                dark
                depressed
                :loading="loading"
                color="primary"
                type="submit"
              >
                Submit
              </v-btn>
            </v-card-actions>
          </v-container>
        </form>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import Layout from '~/layouts/Basic'
import Alert from '~/components/Alert'

export default {
  metaInfo: { title: '2FA' },
  layout: (h, page) => h(Layout, [page]),
  components: {
    Alert
  },
  props: {
    email: {
      type: String,
      required: true,
    },
    password: {
      type: String,
      required: true,
    },
  },
  data () {
    return {
      loading: false,
      form: {
        code: null,
        email: null,
        password: null,
      },
    }
  },

  created () {
    this.form.email = this.email
    this.form.password = this.password
  },

  methods: {
    submit () {
      this.loading = true
      this.$inertia.post(this.route('auth.login'), this.form).then(() => this.loading = false)
    },
  },
}
</script>
