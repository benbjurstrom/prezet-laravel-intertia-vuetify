<template>
  <form @submit.prevent="save">
    <v-card flat>
      <v-toolbar
        flat
      >
        <v-toolbar-title>Create Team</v-toolbar-title>
        <v-spacer />
        <v-btn icon @click="$emit('close')">
          <v-icon>close</v-icon>
        </v-btn>
      </v-toolbar>
      <v-card-text>
        <v-text-field
          v-model="form.name"
          label="New Team"
          required
          class="form-control"
          name="name"
          :class="{ 'is-invalid': pageHasError('name') }"
          :error="pageHasError('name')"
          :error-messages="getPageError('name')"
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
      name: null,
    },
  }),

  methods: {
    cancel () {
      this.$emit('cancel')
      this.$emit('close')
    },
    save () {
      this.loading = true
      this.$inertia.post(this.route('teams.create'), this.form).then(() => {
        this.loading = false
        if (!this.pageHasErrors) {
          this.cancel()
        }
      })
    },
  }
}
</script>
