<template>
  <v-snackbar
    v-model="$root.flashSnackbar"
    color="accent"
    multi-line
    :timeout="10000"
    top
    right
    @input="close"
  >
    {{ $root.flashMessage }}
    <v-btn
      text
      icon
      color="primary"
      @click="close"
    >
      <v-icon small>
        close
      </v-icon>
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
