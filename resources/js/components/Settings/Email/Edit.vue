<template>
  <form @submit.prevent="save">
    <v-card flat>
      <v-toolbar
        flat
      >
        <v-toolbar-title>Update Email</v-toolbar-title>
        <v-spacer />
        <v-btn icon @click="$emit('close')">
          <v-icon>close</v-icon>
        </v-btn>
      </v-toolbar>
      <v-card-text>
        <span>
          A confirmation email will be sent to your new email address.
          To compete the address change you must follow the link in the email.
          Until the change is complete you must continue to login with your existing email.
        </span>
      </v-card-text>
      <v-card-text>
        <v-text-field
          v-model="form.email"
          label="New Email"
          required
          class="form-control"
          type="email"
          name="email"
          :class="{ 'is-invalid': pageHasError('email') }"
          :error="pageHasError('email')"
          :error-messages="getPageError('email')"
        />
      </v-card-text>
      <v-card-actions>
        <v-spacer />
        <v-btn color="primary" text @click="cancel">
          Cancel
        </v-btn>
        <v-btn
          :loading="loading"
          color="primary"
          type="submit"
        >
          Save
        </v-btn>
      </v-card-actions>
    </v-card>
  </form>
</template>

<script>

export default {
  components: {
    //
  },

  data: () => ({
    loading: false,
    form: {
      email: null,
    },
  }),

  created () {
    this.form.email = this.$page.auth.user.email
  },

  methods: {
    cancel () {
      this.$emit('cancel')
      this.$emit('close')
    },
    save () {
      this.loading = true
      this.$inertia.post(this.route('email.update'), this.form).then(() => {
        this.loading = false
        if (!this.pageHasErrors) {
          this.cancel()
        }
      })
    },
  }
}
</script>
