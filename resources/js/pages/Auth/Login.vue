<template>
  <v-container pa-0 fluid class="fill-height" style="background: #FFFFFF; width: 100%; height: 100%;">
    <v-row
      align="center"
      justify="center"
    >
      <v-col
        cols="12"
        sm="8"
        md="4"
      >
        <v-card-title>
          <!--<v-img
            :max-height="200"
            :src=""
            contain
          />-->
        </v-card-title>
        <form @submit.prevent="submit">
          <v-container>
            <v-card-text class="text-center font-weight-regular">
              Sign in to start your session
            </v-card-text>
            <v-spacer />
            <v-card-text>
              <v-text-field
                v-model="form.email"
                label="Email"
                append-icon="email"
                outlined
                :class="{ 'is-invalid': $page.errors.email }"
                class="form-control"
                type="email"
                name="email"
                :error="($page.errors) && ($page.errors.email)"
                :error-messages="$page.errors.email"
              />
              <v-text-field
                v-model="form.password"
                label="Password"
                outlined
                :class="{ 'is-invalid': $page.errors.password }"
                class="form-control"
                type="password"
                name="password"
                :error="($page.errors) && ($page.errors.email)"
                :error-messages="$page.errors.password"
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
                tile
                depressed
                :loading="loading"
                color="light-blue darken-2"
                type="submit"
              >
                Sign In
              </v-btn>
            </v-card-actions>
            <v-btn
              text
              small
              color="light-blue darken-2"
              @click.prevent="forgotPassword"
            >
              I forgot my password
            </v-btn>
          </v-container>
        </form>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import Layout from '~/layouts/Basic'
export default {
  metaInfo: { title: 'Login' },
  layout: (h, page) => h(Layout, [page]),
  props: {
    errors: {
      type: Object,
      default: () => {},
    },
  },
  data () {
    return {
      loading: false,
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
      this.$inertia.post(this.route('login.attempt'), {
        email: this.form.email,
        password: this.form.password,
        remember: this.form.remember,
      }).then(() => this.loading = false)
    },
  },
}
</script>
