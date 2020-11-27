export const state = () => ({
  list: []
})

export const getters = {
  list: (state) => {
    return state.list
  },

  getRootProvidersById: (state) => {
    return (id) => {
      return state.rootProviders.providers.find((val) => {
        return val.provider_id === id
      })
    }
  }
}

export const mutations = {
  setList (state, payload) {
    state.list = payload
  }
}

export const actions = {
  getAll ({ commit }) {
    return this.$axios.$get('/pass').then((res) => {
      commit('setList', res)
    })
  },
  store ({ commit }, { fio, addressId }) {
    return this.$axios.$post('/pass', {
      fio,
      address_id: addressId
    })
  },
  update ({ commit }, { id, fio, status, addressId }) {
    return this.$axios.$put('/pass/' + id, {
      fio,
      status,
      address_id: addressId
    })
  },
  delete ({ commit }, { id }) {
    return this.$axios.$delete('/pass/' + id)
  }
}
