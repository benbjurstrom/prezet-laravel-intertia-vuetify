<template>
  <form @submit.prevent="submit">
    <v-container>
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
        <v-text-field
          v-model="form.password"
          label="Password"
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
        <v-checkbox
          v-model="form.remember"
          label="Remember Me"
          color="#033"
        />
        <v-spacer />
        <v-btn
          dark
          depressed
          :loading="loading"
          color="primary"
          type="submit"
        >
          Login
        </v-btn>
      </v-card-actions>
      <v-btn
        text
        small
        color="primary"
        @click.prevent="forgotPassword"
      >
        Reset Password
      </v-btn>
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
      this.$inertia.post(this.route('auth.login.attempt'), {
        email: this.form.email,
        password: this.form.password,
        remember: this.form.remember,
      }).then(() => this.loading = false)
    },
  },
}
</script>
