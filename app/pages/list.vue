<template>
  <v-layout>
    <v-row
      v-if="$store.getters['user/currentUser'].role === 'admin'"
      align="center"
      justify="center"
    >
      <v-col md="4" sm="6">
        <v-data-table
          :headers="headers"
          :items="pass"
          :loading="loadingTable"
        ></v-data-table>
      </v-col>
    </v-row>
  </v-layout>
</template>

<script>
export default {
  data () {
    return {
      loadingTable: false,
      headers: [
        {
          sortable: false,
          text: 'ID',
          value: 'id'
        },
        {
          sortable: false,
          text: 'Имя',
          value: 'fio'
        },
        {
          sortable: false,
          text: 'Статус',
          value: 'status'
        },
        {
          sortable: false,
          text: 'Адрес',
          value: 'address'
        }
      ]
    }
  },

  computed: {
    pass () {
      return this.$store.getters['pass/list']
    }
  },

  async fetch () {
    await this.$store.dispatch('user/getCurrentUser')
    await this.$store.dispatch('pass/getAll')
  }
}
</script>

<style scoped>

</style>
