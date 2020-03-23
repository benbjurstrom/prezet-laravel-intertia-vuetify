<template>
  <v-snackbar
    v-model="$root.flashSnackbar"
    color="primary"
    multi-line
    :timeout="4000"
    top
    right
    @input="close"
  >
    {{ $root.flashMessage }}
    <v-btn
      dark
      text
      @click="close"
    >
      Close
    </v-btn>
  </v-snackbar>
</template>

<script>
export default {
  name: 'FlashMessages',
  data: vm => ({}),
  methods: {
    close () {
      this.$root.flashSnackbar = false
      this.$root.flashMessage = ''
    }
  }
}
</script>
