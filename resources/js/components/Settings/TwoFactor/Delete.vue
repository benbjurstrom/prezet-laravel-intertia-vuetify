<template>
  <form @submit.prevent="save">
    <v-card flat>
      <v-toolbar
        flat
      >
        <v-toolbar-title>{{ title }}</v-toolbar-title>
        <v-spacer />
        <v-btn icon @click="$emit('close')">
          <v-icon>close</v-icon>
        </v-btn>
      </v-toolbar>
      <v-card-text>
        {{ message }}
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
          Confirm
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

  props: {
    title: {
      type: String,
      required: true
    },
    message: {
      type: String,
      required: true
    },
    routeName: {
      type: String,
      required: true
    },
    method: {
      type: String,
      required: true
    },
    form: {
      type: Object,
      default: null
    }
  },

  data: () => ({
    loading: false
  }),

  methods: {
    cancel () {
      this.$emit('cancel')
      this.$emit('close')
    },
    save () {
      this.loading = true

      this.$inertia.delete(this.route(this.routeName)).then(() => {
        this.loading = false
        if (!this.pageHasErrors) {
          this.cancel()
        }
      })
    },
  }
}
</script>
