<template>
  <v-layout>
    <v-row
      align="center"
      justify="center"
    >
      <v-col md="8" sm="8">
        <v-card>
          <v-card-title class="font-weight-light">Заказать пропуск</v-card-title>
          <v-card-text v-if="$store.getters['pass/list'].length > 0">
            <v-col cols="12" align-self="center">
              ФИО: {{ $store.getters['pass/list'][0].fio }}
            </v-col>
            <v-col cols="12" align-self="center">
              Статус: {{ $store.getters['pass/list'][0].status }}
            </v-col>
            <v-col cols="12" align-self="center">
              Адрес: {{ $store.getters['pass/list'][0].address.name }}
            </v-col>
          </v-card-text>
          <v-card-text v-else>
            <v-form @submit.stop.prevent="tryCreatePass">
              <v-container class="py-0">
                <v-row>
                  <v-col cols="2" align-self="center" class="d-flex justify-center">
                    <v-icon>mdi-alpha-n-box</v-icon>
                  </v-col>
                  <v-col cols="10" class="py-0">
                    <v-select
                      v-model="createAddress"
                      :items="$store.getters['address/list']"
                      item-text="name"
                      item-value="id"
                      label="Адрес"
                    />
                  </v-col>
                  <v-col cols="2" align-self="center" class="d-flex justify-center">
                    <v-icon>mdi-alpha-n-box</v-icon>
                  </v-col>
                  <v-col cols="10" class="py-0">
                    <v-text-field
                      :label="'ФИО'"
                      class="purple-input"
                      v-model="createName"
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
                      :loading="loadingCreatePass"
                    >
                      Заказать
                    </v-btn>
                  </v-col>
                </v-row>
              </v-container>
            </v-form>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-layout>
</template>

<script>
export default {
  layout: 'auth',

  data () {
    return {
      loadingCreatePass: false,
      createName: null,
      createAddress: null
    }
  },

  methods: {
    tryCreatePass () {
      this.loadingCreatePass = true
      this.$store.dispatch('pass/store', {
        fio: this.createName,
        addressId: this.createAddress
      }).then(() => {
        this.$store.dispatch('pass/getAll')
      }).catch(() => {
        alert('Что-то пошло не так')
      }).finally(() => {
        this.loadingCreatePass = false
      })
    }
  },

  async fetch () {
    await this.$store.dispatch('pass/getAll')
    await this.$store.dispatch('address/getAll')
  }
}
</script>
