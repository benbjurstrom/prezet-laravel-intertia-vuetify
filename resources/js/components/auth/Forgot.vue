<template>
  <form @submit.prevent="submit">
    <v-container>
      <v-card-text>
        To Reset your password, enter the email you use to login.
        A link will be emailed to this address which will let you reset your password.
      </v-card-text>
      <v-card-text>
        <v-text-field
          v-model="form.email"
          label="Email"
          append-icon="email"
          outlined
          class="form-control"
          type="email"
          name="email"
          :class="{ 'is-invalid': pageHasError('email') }"
          :error="pageHasError('email')"
          :error-messages="getPageError('email')"
        />
      </v-card-text>
      <v-card-actions>
        <inertia-link class="v-btn v-btn--flat v-btn--text theme--light v-size--small primary--text" :href="route('auth.login')" method="get">
          Back to Login
        </inertia-link>
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
</template>

<script>
import Layout from '~/layouts/Basic'

export default {
  metaInfo: { title: 'Login' },
  layout: (h, page) => h(Layout, [page]),
  components: {
    //
  },
  data () {
    return {
      loading: false,
      showPassword: false,
      form: {
        email: null,
        password: null,
        remember: null,
      },
    }
  },
  methods: {
    submit () {
      this.loading = true
      this.$inertia.post(this.route('auth.password.reset.store'), this.form).then(() => this.loading = false)
    },
  },
}
</script>
