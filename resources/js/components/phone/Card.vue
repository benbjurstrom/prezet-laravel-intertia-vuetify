<template>
  <v-card outlined>
    <v-list>
      <v-list-item link @click.stop="openItem(item)">
        <!--<v-list-item-action />-->
        <v-list-item-icon>
          <v-icon color="primary">
            phone
          </v-icon>
        </v-list-item-icon>

        <v-list-item-content>
          <v-list-item-title>+1 888.555.5555</v-list-item-title>
          <v-list-item-subtitle>Home</v-list-item-subtitle>
        </v-list-item-content>

        <v-list-item-icon>
          <v-btn icon>
            <v-icon small>
              delete
            </v-icon>
          </v-btn>
        </v-list-item-icon>
      </v-list-item>
    </v-list>

    <v-card-actions>
      <v-btn block text color="primary" @click.stop="openItem(item)">
        New Phone
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
// import Edit from '~/components/email/Edit'

export default {
  components: {
    // Edit
  },

  props: {
    // contact: {
    //   type: Object,
    //   required: true
    // }
  },
}
</script>
