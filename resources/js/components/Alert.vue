<template>
  <v-card v-if="show" flat>
    <v-card-text>
      <v-alert
        dense
        outlined
        :type="type"
        dismissible
        @input="dismiss"
      >
        {{ message }}
      </v-alert>
    </v-card-text>
  </v-card>
</template>

<script>

export default {
  props: {
    message: {
      type: String,
      default: 'There were some problems with your input.'
    },
    type: {
      type: String,
      default: 'error'
    },
  },

  data: vm => ({
    dismissed: false
  }),

  computed: {
    show () {
      if (this.dismissed) {
        return false
      }

      if (this.type === 'error') {
        return this.pageHasErrors
      }

      return true
    },
  },

  methods: {
    dismiss () {
      this.dismissed = true
      this.$page.errors = {}
    }
  }
}
</script>
