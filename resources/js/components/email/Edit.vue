<template>
  <v-card flat>
    <v-toolbar
      flat
      class="mb-4"
    >
      <v-toolbar-title>Update Email</v-toolbar-title>
      <v-spacer />
      <v-btn icon @click="$emit('close')">
        <v-icon>close</v-icon>
      </v-btn>
    </v-toolbar>
    <v-card-text>
      <v-text-field
        v-model="email"
        label="New Email"
        required
      />
    </v-card-text>
    <v-card-actions>
      <v-spacer />
      <v-btn color="blue darken-1" text @click="cancel">
        Cancel
      </v-btn>
      <v-btn
        :loading="isLoading"
        color="blue darken-1"
        text
        @click="save"
      >
        Save
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>

export default {
  components: {
    //
  },

  props: {
    // email: {
    //   type: String,
    //   required: true
    // }
  },

  methods: {
    cancel () {
      this.$emit('cancel')
      this.$emit('close')
    },
  }
}
</script>
