<template>
  <form @submit.prevent="submit">
    <v-container>
      <v-card-text>
        Your password must consist of At least 8 characters, A mixture of both uppercase and lowercase letters, and A mixture of letters and numbers.
      </v-card-text>
      <v-card-text>
        <v-text-field
          v-model="form.password"
          label="New Password"
          outlined
          :class="{ 'is-invalid': pageHasError('password') }"
          class="form-control"
          name="password"
          :error="pageHasError('password') === true"
          :error-messages="getPageError('password')"
          :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
          :type="showPassword ? 'text' : 'password'"
          @click:append="showPassword = !showPassword"
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
          Update Password
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
      this.$inertia.patch(this.route('auth.password.reset.update', { user: this.userId, token: this.token }), this.form).then(() => this.loading = false)
    },
  },
}
</script>
