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
          <v-card v-if="user.email_pending" flat class="subtitle-2 font-weight-light">
            Email change pending. To complete the change click the link sent to {{ user.email_pending }}.
          </v-card>
          <v-list-item-subtitle v-else>
            {{ verifiedString }}
          </v-list-item-subtitle>
        </v-list-item-content>

        <v-list-item-icon>
          <v-tooltip v-if="user.email_pending" top>
            <template v-slot:activator="{ on }">
              <v-btn icon @click.stop="cancelUpdate" v-on="on">
                <v-icon small>
                  cancel
                </v-icon>
              </v-btn>
            </template>
            <span>Cancel Update</span>
          </v-tooltip>
          <v-btn v-else icon @click.stop="dialog = true">
            <v-icon small>
              edit
            </v-icon>
          </v-btn>
        </v-list-item-icon>
      </v-list-item>
    </v-list>
    <v-card-actions v-if="!verified || user.email_pending">
      <v-btn text block primary :loading="loading" @click="resendVerification">
        Resend Verification
      </v-btn>
    </v-card-actions>

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
import PasswordEdit from '~/components/Settings/Email/Edit'

export default {
  components: {
    PasswordEdit
  },

  props: {
    user: {
      type: Object,
      required: true
    }
  },

  data: () => ({
    dialog: false,
    alert: true,
    loading: false
  }),

  computed: {
    verified () {
      return this.$page.auth.user.email_verified
    },
    verifiedString () {
      return this.verified ? 'Verified' : 'Unverified'
    }
  },
  methods: {
    resendVerification () {
      this.loading = true
      this.$inertia.post(this.route('verification.resend')).then(() => this.loading = false)
    },
    cancelUpdate () {
      this.loading = true
      this.$inertia.delete(this.route('email.destroy')).then(() => this.loading = false)
    },
  },
}
</script>
