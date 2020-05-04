<template>
  <v-toolbar flat color="white" class="body-2">
    <v-spacer />
    <template v-for="(link, key) in links">
      <span v-if="link.url === null" :key="key" class="mr-1 grey--text">
        {{ link.label }}
      </span>
      <inertia-link v-else :key="key" class="mr-1" :class="{ 'active': link.active }" :href="link.url">
        {{ link.label }}
      </inertia-link>
    </template>
  </v-toolbar>
</template>

<script>

export default {
  props: {
    links: {
      type: Array,
      required: true
    }
  },

  data: vm => ({
    //
  }),

  methods: {
    //
  }
}
</script>
<style scoped>
  .active{
    text-decoration: none !important;
  }
</style>
