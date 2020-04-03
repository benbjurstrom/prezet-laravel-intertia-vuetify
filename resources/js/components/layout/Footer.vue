<template>
  <v-footer
    v-ripple="{ center: true }"
    color="background"
    app
    inset
  >
    <v-container class="pa-0 ma-0 d-flex justify-space-between caption" fluid>
      <div />
      <div>
        Prezet &copy; {{ new Date().getFullYear() }}
      </div>
      <div>{{ $page.release }}</div>
    </v-container>
  </v-footer>
</template>

<script>
export default {
  props: {
    //
  },
  data: () => ({
    //
  }),
}
</script>
