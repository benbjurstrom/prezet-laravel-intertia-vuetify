<template>
  <div>
    <v-toolbar flat color="transparent">
      <p class="body-1">
        Teams
      </p>
      <v-spacer />
      <v-btn color="primary" dark class="mb-2" @click.stop="dialog = true">
        New Team
      </v-btn>
    </v-toolbar>

    <TeamTable />

    <v-dialog v-model="dialog" max-width="600px">
      <TeamCreate
        v-if="dialog"
        @close="dialog = false"
      />
    </v-dialog>
  </div>
</template>

<script>
import TeamTable from '~/components/Settings/Team/Table'
import TeamCreate from '~/components/Settings/Team/Create'

export default {
  components: {
    TeamTable,
    TeamCreate
  },

  data: vm => ({
    dialog: false
  }),
}
</script>
