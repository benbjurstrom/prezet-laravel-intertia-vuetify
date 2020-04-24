<template>
  <v-card outlined>
    <v-card-text v-if="pageHasErrors">
      <Alert :form="form" dismissible />
    </v-card-text>
    <v-card-text>
      <p>Trigger a notificaiton in 10 seconds.</p>
    </v-card-text>
    <v-card-actions>
      <v-spacer />
      <v-btn
        dark
        depressed
        :loading="loading"
        color="primary"
        @click.stop="save"
      >
        Notify Me!
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import Alert from '~/components/Alert'
export default {
  components: {
    Alert
  },

  data: () => ({
    loading: false,
    form: {
      password: null,
    }
  }),

  methods: {
    async save () {
      this.loading = true
      await this.$inertia.post(this.route('demo.notifications.store'), this.form).then(() => {
        this.loading = false
      })
    }
  }
}
</script>
