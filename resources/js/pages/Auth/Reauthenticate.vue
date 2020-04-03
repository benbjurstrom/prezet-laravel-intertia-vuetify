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
      <v-card outlined>
        <Alert />
        <form @submit.prevent="submit">
          <v-container>
            <v-card-text>
              You must renter your password to continue.
            </v-card-text>
            <v-card-text>
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
  metaInfo: { title: 'Reauthenticate' },
  layout: (h, page) => h(Layout, [page]),
  components: {
    Alert
  },

  props: {
    //
  },

  data () {
    return {
      loading: false,
      showPassword: false,
      form: {
        password: null,
      },
    }
  },
  methods: {
    submit () {
      this.loading = true
      this.$inertia.post(this.route('auth.reauthenticate'), this.form).then(() => this.loading = false)
    },
  },
}
</script>
