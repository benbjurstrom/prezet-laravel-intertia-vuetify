<template>
  <v-container>
    <v-row v-if="$page.meta.route === 'settings.email'" class="justify-center">
      <v-col md="6" sm="12">
        <p class="body-1">
          Email
        </p>
        <EmailCard
          :user="user"
        />
      </v-col>
    </v-row>
    <v-row v-if="$page.meta.route === 'settings.security'" class="justify-center">
      <v-col md="6" sm="12">
        <p class="body-1">
          Password
        </p>
        <PasswordCard />
      </v-col>
    </v-row>
    <v-row v-if="$page.meta.route === 'settings.security'" class="justify-center">
      <v-col md="6" sm="12">
        <p class="body-1">
          2FA
        </p>
        <TwoFactorCard
          :two-factor="twoFactor"
        />
      </v-col>
    </v-row>
    <v-row v-if="$page.meta.route === 'settings.teams'" class="justify-center">
      <v-col md="6" sm="12">
        <TeamApp />
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import Layout from '~/layouts/Default'
import TeamApp from '~/components/Settings/Team/App'
import EmailCard from '~/components/Settings/Email/Card'
import PasswordCard from '~/components/Settings/Password/Card'
import TwoFactorCard from '~/components/Settings/TwoFactor/Card'

export default {
  metaInfo: { title: 'Settings' },

  layout: (h, page) => h(Layout, [page]),

  components: {
    EmailCard,
    PasswordCard,
    TwoFactorCard,
    TeamApp
  },

  props: {
    user: {
      type: Object,
      default: () => {}
    },
    twoFactor: {
      type: Boolean,
      default: false
    }
  },

  data: () => ({
    //
  }),
}
</script>
