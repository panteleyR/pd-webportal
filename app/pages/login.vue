<template>
  <v-row align="center" justify="center">
    <v-col md="4" sm="6">
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: 'Login',
  layout: 'auth',

  data () {
    return {
      login: '',
      password: '',
      loading: false
    }
  },

  computed: {
    test () {
      return '124'
    }
  },

  methods: {
    tryLogin () {
      this.loading = true
      this.$axios.$post('/login', {
        login: this.login,
        password: this.password
      }).then((response) => {
        this.$cookies.set('access-token', response.remember_token)
        this.$axios.defaults.headers.common.Authorization = 'Bearer ' + this.$cookies.get('access-token')
        this.$routeri18n.push('list')
      }).catch((error) => {
          this.$notify.show(error, 'error')
      }).finally(() => {
        this.loading = false
      })
    }
  }
}
</script>

<style scoped>

</style>
