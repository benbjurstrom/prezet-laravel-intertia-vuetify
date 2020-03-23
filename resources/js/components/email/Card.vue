<template>
  <v-card outlined>
    <v-list>
      <v-list-item>
        <!--<v-list-item-action />-->
        <v-list-item-icon>
          <v-icon color="primary">
            mail
          </v-icon>
        </v-list-item-icon>

        <v-list-item-content>
          <v-list-item-title>{{ $page.auth.user.email }}</v-list-item-title>
          <v-list-item-subtitle>{{ verifiedText }}</v-list-item-subtitle>
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

    <v-card-actions v-if="!verified">
      <inertia-link
        class="v-btn v-btn--block v-btn--flat v-btn--text theme--light v-size--default primary--text"
        :href="route('verification.resend')"
        method="post"
      >
        Resend Verification
      </inertia-link>
    </v-card-actions>

    <!-- Edit Dialog -->
    <v-dialog v-model="dialog" max-width="600px">
      <PasswordEdit
        v-if="dialog"
        :item="item"
        @close="dialog = false"
      />
    </v-dialog>
  </v-card>
</template>

<script>
import PasswordEdit from '~/components/email/Edit'

export default {
  components: {
    PasswordEdit
  },

  props: {
    // user: {
    //   type: Object,
    //   required: true
    // }
  },

  data: () => ({
    dialog: false
  }),

  computed: {
    verified () {
      return this.$page.auth.user.email_verified
    },
    verifiedText () {
      return this.verified ? 'Verified' : 'Unverified'
    }
  },
}
</script>
