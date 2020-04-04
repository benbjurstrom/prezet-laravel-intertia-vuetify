<template>
  <v-card flat>
    <v-toolbar
      flat
    >
      <v-toolbar-title>Update Password</v-toolbar-title>
      <v-spacer />
      <v-btn icon @click="$emit('close')">
        <v-icon>close</v-icon>
      </v-btn>
    </v-toolbar>
    <v-card-text>
      <span>
        Your password must consist of At least 8 characters, A mixture of both uppercase and lowercase letters and A mixture of letters and numbers.
      </span>
    </v-card-text>
    <v-card-text>
      <Alert :form="form" dismissible />
    </v-card-text>
    <v-card-text>
      <v-text-field
        v-model="form.password"
        label="New Password"
        required
        :class="{ 'is-invalid': $page.errors.password }"
        :error="errors && ($page.errors.password !== undefined)"
        :error-messages="$page.errors.password"
        hint="At least 8 characters"
        :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
        :type="showPassword ? 'text' : 'password'"
        @click:append="showPassword = !showPassword"
      />
    </v-card-text>
    <v-card-actions>
      <v-spacer />
      <v-btn color="blue darken-1" text @click="cancel">
        Cancel
      </v-btn>
      <v-btn
        :loading="loading"
        color="blue darken-1"
        text
        @click="save"
      >
        Save
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import Alert from '~/components/Alert'
export default {
  components: {
    Alert
  },

  data: () => ({
    loading: false,
    showPassword: false,
    form: {
      password: null,
    },
    rules: {
      required: value => !!value || 'Required.',
      min: v => v.length >= 8 || 'Min 8 characters'
    },
  }),

  computed: {
    errors () {
      return Object.keys(this.$page.errors).length > 0
    }
  },

  methods: {
    async save () {
      this.loading = true
      await this.$inertia.patch(this.route('auth.password.update'), this.form).then(() => {
        this.loading = false

        if (!this.errors) {
          this.$emit('close')
        }
      })
    },

    cancel () {
      this.$emit('cancel')
      this.$emit('close')
    },
  }
}
</script>
