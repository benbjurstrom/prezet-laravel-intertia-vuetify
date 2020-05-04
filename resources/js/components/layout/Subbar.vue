<template>
  <v-card v-if="$page.title" flat>
    <v-card-text>
      <v-card-text>
        <h2 class="title">
          {{ $page.title }}
        </h2>
      </v-card-text>
      <v-divider v-if="$page.tabs" />
      <v-tabs v-if="$page.tabs" v-model="active">
        <v-tab v-for="tab in $page.tabs" :key="tab.label" @click="click(tab)">
          {{ tab.label }}
        </v-tab>
      </v-tabs>
    </v-card-text>
  </v-card>
</template>
<script>
export default {
  data: () => ({
    active: null
  }),
  mounted () {
    for (const key in this.$page.tabs) {
      if (!this.$page.tabs[key].route) {
        this.active = parseInt(key)
        return
      }
    }
  },
  methods: {
    click (tab) {
      this.$inertia.visit(this.route(tab.route))
    }
  }
}
</script>
