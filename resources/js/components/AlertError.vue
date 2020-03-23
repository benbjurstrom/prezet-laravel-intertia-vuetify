<template>
  <v-card v-if="Object.keys($page.errors).length" flat>
    <v-card-text>
      <v-alert
        dense
        outlined
        type="error"
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
  },

  methods: {
    dismiss () {
      this.$page.errors = {}
    }
  }
}
</script>
