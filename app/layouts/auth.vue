<template>
  <v-app dark>
    <v-app-bar
      absolute
      app
      dark
      height="75"
      color="transparent"
      :elevation="0"
    >
      <v-container class="d-flex align-center px-0 ">
        <v-toolbar-title
          class=" font-weight-light"
          v-text="'pd-polytech.local'"
        />
        <v-spacer />
        <v-btn v-if="getRouteBaseName() === 'list'" text @click="$routeri18n.push('login')">
          <v-icon>mdi-arrow-right-thick</v-icon>
          <div v-if="this.$vuetify.breakpoint.smAndUp">Выход</div>
        </v-btn>
        <v-btn v-if="getRouteBaseName() !== 'login' && getRouteBaseName() !== 'list'" text @click="$routeri18n.push('login')">
          <v-icon>mdi-door</v-icon>
          <div v-if="this.$vuetify.breakpoint.smAndUp">Вход</div>
        </v-btn>
      </v-container>
    </v-app-bar>
    <v-main class="pa-0">
      <v-img
        src="https://images.unsplash.com/photo-1504805572947-34fad45aed93?ixlib=rb-1.2.1&auto=format&fit=crop&w=1500&q=80"
        aspect-ratio="2"
        min-height="100vh"
        position="center"
        gradient="to top right, rgba(0,0,0,.5), rgba(0,0,0,.5)"
      >
        <v-responsive class="d-flex align-center py-16" min-height="100vh">
          <v-container class="fill-heigh justify-center">
            <nuxt />
          </v-container>
        </v-responsive>
      </v-img>
    </v-main>
    <v-footer
      absolute
      app
      dark
      height="75"
      color="transparent"
      :elevation="0"
    >
      <v-container class="d-flex align-center px-0 ">
        <v-spacer />
        <span>© 20 pd-polytech.local</span>
      </v-container>
    </v-footer>
  </v-app>
</template>

<script>
export default {
  name: 'auth',

  data () {
    return {
      snackbar: false
    }
  },

  computed: {
    pageName () {
      return this.$store.getters.pageName
    },
    // notify: {
    //   get () {
    //     return this.$store.getters['notification/notify']
    //   },
    //   set (val) {
    //     console.log(val)
    //     // this.$store.commit('notification/changeShow', val)
    //     if (val === false) {
    //       this.$store.commit('notification/clearNotify')
    //     }
    //   }
    // }
    notify () {
      return this.$store.getters['notification/show']
    },

    notifyText () {
      return this.$store.getters['notification/text']
    },

    notifyColor () {
      return this.$store.getters['notification/color']
    }
  },

  watch: {
    notify (newVal) {
      this.snackbar = newVal
    },

    snackbar (newVal, oldVal) {
      if (newVal === false) {
        this.$store.commit('notification/clearNotify')
      }
    }
  },

  mounted () {
    this.$vuetify.theme.dark = false
  }
}
</script>
