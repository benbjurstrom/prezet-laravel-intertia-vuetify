<template>
  <v-footer
    v-ripple="{ center: true }"
    color="white"
    app
    inset
  >
    <v-container class="pa-0 ma-0 d-flex justify-space-between caption" fluid>
      <div />
      <div>
        {{ new Date().getFullYear() }}
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
