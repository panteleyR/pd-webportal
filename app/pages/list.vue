<template>
  <v-layout>
    <v-row
      v-if="$store.getters['user/currentUser'] ? $store.getters['user/currentUser'].role.name === 'Admin' : false"
      align="center"
      justify="center"
    >
      <v-col md="8" sm="8">
        <v-data-table
          :headers="headers"
          :items="pass"
          :loading="loadingTable"
        >
          <template v-slot:item.address="{ item }">
            {{ item.address.name }}
          </template>

          <template v-slot:item.delete="{ item }">
            <v-btn icon>
              <v-icon
                small
                @click="deletePass(item)"
                color="error"
              >
                mdi-delete
              </v-icon>
            </v-btn>
          </template>
          <template v-slot:item.edit="{ item }">
            <v-btn
              icon
            >
              <v-icon
                small
                @click="editPass(item)"
              >
                mdi-pencil
              </v-icon>
            </v-btn>
          </template>
        </v-data-table>
      </v-col>
    </v-row>
    <v-dialog
      v-model="dialogDeletePass"
      light
      max-width="500"
    >
      <v-card class="text-center">
        <v-card-title>
          Удалить кампнию

          <v-spacer />

          <v-icon
            aria-label="Close"
            @click="dialogDeletePass = false"
          >
            mdi-close
          </v-icon>
        </v-card-title>

        <v-card-text>
          <v-col cols="12" align-self="center">
            Вы действительно хотите удалить заказ
          </v-col>
        </v-card-text>

        <v-card-actions>
          <v-spacer />
          <v-btn
            color="error"
            text
            type="submit"
            @click="tryDeletePass"
            :loading="loadingDeletePass"
          >
            Удалить
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="dialogUpdatePass"
      light
      max-width="500"
    >
      <v-card class="text-center">
        <v-card-title>
          Обновить пропускной
          <v-spacer />
          <v-icon
            aria-label="Close"
            @click="dialogUpdatePass = false"
          >
            mdi-close
          </v-icon>
        </v-card-title>

        <v-form @submit.stop.prevent="tryUpdatePass">
          <v-container class="py-0">
            <v-row>
              <v-col cols="2" align-self="center" class="d-flex justify-center">
                <v-icon>mdi-alpha-n-box</v-icon>
              </v-col>
              <v-col cols="10" class="py-0">
                <v-select
                  v-model="updateStatus"
                  :items="status"
                  item-text="name"
                  item-value="name"
                  label="Статус"
                />
              </v-col>
              <v-col cols="2" align-self="center" class="d-flex justify-center">
                <v-icon>mdi-alpha-n-box</v-icon>
              </v-col>
              <v-col cols="10" class="py-0">
                <v-select
                  v-model="updateAddress"
                  :items="address"
                  item-text="name"
                  item-value="id"
                  label="Статус"
                />
              </v-col>
              <v-col cols="2" align-self="center" class="d-flex justify-center">
                <v-icon>mdi-alpha-n-box</v-icon>
              </v-col>
              <v-col cols="10" class="py-0">
                <v-text-field
                  :label="'ФИО'"
                  class="purple-input"
                  v-model="updateName"
                  ref="name"
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
                  :loading="loadingUpdatePass"
                >
                  Обновить
                </v-btn>
              </v-col>
            </v-row>
          </v-container>
        </v-form>
      </v-card>
    </v-dialog>

  </v-layout>
</template>

<script>
export default {
  layout: 'auth',

  data () {
    return {
      loadingTable: false,
      loadingUpdatePass: false,
      loadingDeletePass: false,
      deleteId: null,
      dialogDeletePass: false,
      dialogUpdatePass: false,
      updateId: null,
      updateName: null,
      updateStatus: null,
      updateAddress: null,
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
        },
        {
          sortable: false,
          text: 'Редактировать',
          value: 'edit'
        },
        {
          sortable: false,
          text: 'Удалить',
          value: 'delete'
        }
      ]
    }
  },

  computed: {
    pass () {
      return this.$store.getters['pass/list']
    },
    status () {
      return ['Обрабатывается', 'Готово']
    },
    address () {
      return this.$store.getters['address/list']
    }
  },

  methods: {
    deletePass (item) {
      this.deleteId = item.id
      this.dialogDeletePass = true
    },
    editPass (item) {
      this.updateId = item.id
      this.updateName = item.fio
      this.updateAddress = item.address.id
      this.updateStatus = item.status
      this.dialogUpdatePass = true
    },
    tryDeletePass () {
      this.loadingDeletePass = true
      this.$store.dispatch('pass/delete', {
        id: this.deleteId
      }).then(() => {
        this.$store.dispatch('pass/getAll')
      }).catch(() => {
        alert('Что-то пошло не так')
      }).finally(() => {
        this.dialogDeletePass = false
        this.loadingDeletePass = false
      })
    },
    tryUpdatePass () {
      this.loadingUpdatePass = true
      this.$store.dispatch('pass/update', {
        fio: this.updateName,
        id: this.updateId,
        status: this.updateStatus,
        addressId: this.updateAddress
      }).then(() => {
        this.$store.dispatch('pass/getAll')
      }).catch(() => {
        alert('Что-то пошло не так')
      }).finally(() => {
        this.dialogUpdatePass = false
        this.loadingUpdatePass = false
      })
    }
  },

  async fetch () {
    await this.$store.dispatch('user/getCurrentUser')
    await this.$store.dispatch('pass/getAll')
    await this.$store.dispatch('address/getAll')
  }
}
</script>

<style scoped>

</style>
