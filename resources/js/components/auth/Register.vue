<template>
  <form @submit.prevent="submit">
    <v-container>
      <v-card-text>
        <v-text-field
          v-model="form.name"
          label="Name"
          append-icon="account_circle"
          outlined
          class="form-control"
          type="text"
          name="name"
          :class="{ 'is-invalid': pageHasError('name') }"
          :error="pageHasError('name')"
          :error-messages="getPageError('name')"
        />
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
          class="form-control"
          name="password"
          :class="{ 'is-invalid': pageHasError('password') }"
          :error="pageHasError('password')"
          :error-messages="getPageError('password')"
          :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
          :type="showPassword ? 'text' : 'password'"
          @click:append="showPassword = !showPassword"
        />
      </v-card-text>
      <v-card-actions>
        <v-checkbox
          v-model="form.accepted"
          label="Agree to terms"
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
          Create Account
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
      this.$inertia.post(this.route('auth.register'), {
        name: this.form.name,
        email: this.form.email,
        password: this.form.password,
        accepted: this.form.accepted,
      }).then(() => this.loading = false)
    },
  },
}
</script>
