<template>
  <v-card outlined>
    <data-table-wrapper
      :items="$page.teams.data"
      :links="$page.teams.links"
      :headers="headers"
      sort-by="name"
    >
      <template #top="{ top }">
        <v-toolbar flat color="white">
          <v-spacer />
          <v-text-field
            v-model="search"
            append-icon="search"
            single-line
            hide-details
          />
        </v-toolbar>
      </template>
      <template #item="{ item }">
        <tr>
          <td>
            {{ item.name }}
          </td>
          <td class="text-right">
            <v-btn text icon @click="edit(item.id)">
              <v-icon>edit</v-icon>
            </v-btn>
          </td>
        </tr>
      </template>
    </data-table-wrapper>
  </v-card>
</template>

<script>
export default {

  props: {
    //
  },

  data: vm => ({
    search: '',
    headers: [
      { text: 'Name', value: 'name', sortable: false },
      { text: '', sortable: false },
    ],
  }),

  methods: {
    edit (item) {
      console.log(item)
    }
  }
}
</script>
