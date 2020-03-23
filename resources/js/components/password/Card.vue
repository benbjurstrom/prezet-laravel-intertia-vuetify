<template>
  <v-card outlined>
    <v-list>
      <v-list-item>
        <!--<v-list-item-action />-->
        <v-list-item-icon>
          <v-icon color="primary">
            lock
          </v-icon>
        </v-list-item-icon>

        <v-list-item-content>
          <v-list-item-title>&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;</v-list-item-title>
          <v-list-item-subtitle>Last updated: 0/01/2020</v-list-item-subtitle>
        </v-list-item-content>

        <v-list-item-icon>
          <v-btn icon @click.stop="dialog = true">
            <v-icon small>
              edit
            </v-icon>
          </v-btn>
        </v-list-item-icon>
      </v-list-item>
    </v-list>
    <!-- Edit Dialog -->
    <v-dialog v-model="dialog" max-width="600px">
      <PasswordEdit
        v-if="dialog"
        @close="dialog = false"
      />
    </v-dialog>
  </v-card>
</template>

<script>
import PasswordEdit from '~/components/password/Edit'

export default {
  components: {
    PasswordEdit
  },

  props: {
    //
  },

  data: () => ({
    dialog: false
  })
}
</script>
