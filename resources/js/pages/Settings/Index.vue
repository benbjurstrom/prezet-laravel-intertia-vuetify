<template>
  <v-container>
    <v-row class="justify-center">
      <v-col md="6" sm="12">
        <p class="body-1">
          Email
        </p>
        <EmailCard
          :user="user"
        />
      </v-col>
    </v-row>

    <v-row class="justify-center">
      <v-col md="6" sm="12">
        <p class="body-1">
          Password
        </p>
        <PasswordCard />
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import Layout from '~/layouts/Default'
import EmailCard from '~/components/Settings/Email/Card'
import PasswordCard from '~/components/Settings/Password/Card'

export default {
  metaInfo: { title: 'Settings' },

  layout: (h, page) => h(Layout, [page]),

  components: {
    EmailCard,
    PasswordCard,
  },

  props: {
    user: {
      type: Object,
      required: true
    }
  },

  data: () => ({
    //
  }),
}
</script>
