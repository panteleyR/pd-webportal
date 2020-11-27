<template>
  <v-row align="center" justify="center">
    <v-col md="4" sm="6">
      <v-card>
        <v-col class="pa-0" cols="12">
          <v-card-title class="font-weight-light">Вход</v-card-title>
        </v-col>
        <v-form @submit.stop.prevent="tryLogin()">
          <v-container class="py-0">
            <v-row>
              <v-col cols="2" align-self="center" class="d-flex justify-center">
                <v-icon>mdi-account</v-icon>
              </v-col>
              <v-col cols="10" class="py-0">
                <v-text-field
                  :label="'Логин'"
                  class="purple-input"
                  v-model="login"
                />
              </v-col>
              <v-col cols="2" align-self="center" class="d-flex justify-center">
                <v-icon>mdi-account-key</v-icon>
              </v-col>
              <v-col cols="10" class="py-0">
                <v-text-field
                  :label="'Пароль'"
                  class="purple-input"
                  type="password"
                  v-model="password"
                />
              </v-col>

              <v-col
                cols="12"
                class="text-right"
              >
                <v-btn
                  color="primary"
                  class="mr-0"
                  type="submit"
                  :loading="loading"
                >
                  Вход
                </v-btn>
              </v-col>
            </v-row>
          </v-container>
        </v-form>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
export default {
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
