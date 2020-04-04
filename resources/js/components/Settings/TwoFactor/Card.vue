<template>
  <v-card outlined>
    <v-list>
      <v-list-item>
        <!--<v-list-item-action />-->
        <v-list-item-icon>
          <v-icon color="primary">
            looks_two
          </v-icon>
        </v-list-item-icon>

        <v-list-item-content>
          <v-list-item-title>Two Factor Authentication</v-list-item-title>
          <v-list-item-subtitle>{{ status }}</v-list-item-subtitle>
        </v-list-item-content>

        <v-list-item-icon>
          <v-tooltip v-if="twoFactor" top>
            <template v-slot:activator="{ on }">
              <v-btn icon @click.stop="dialog=true" v-on="on">
                <v-icon small>
                  delete
                </v-icon>
              </v-btn>
            </template>
            <span>Remove 2FA</span>
          </v-tooltip>
          <inertia-link v-else class="v-btn v-btn--flat v-btn--icon v-btn--round theme--light v-size--default" :href="route('settings.2fa.create')" method="get">
            <v-icon small>
              arrow_forward
            </v-icon>
          </inertia-link>
        </v-list-item-icon>
      </v-list-item>
    </v-list>
    <!-- Edit Dialog -->
    <v-dialog v-model="dialog" max-width="600px">
      <TwoFactorDelete
        v-if="dialog"
        title="Remove 2FA"
        message="Are you sure you want ot remove 2FA from this account?"
        route-name="settings.2fa.destroy"
        method="delete"
        @close="dialog = false"
      />
    </v-dialog>
  </v-card>
</template>

<script>
import TwoFactorDelete from '~/components/Settings/TwoFactor/Delete'

export default {
  components: {
    TwoFactorDelete
  },

  props: {
    twoFactor: {
      type: Boolean,
      required: true
    },
  },

  data: () => ({
    dialog: false,
  }),

  computed: {
    status () {
      return (this.twoFactor) ? 'Enabled' : 'Disabled'
    }
  },

}
</script>
