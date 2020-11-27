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
    return this.$axios.$get(process.env.baseUrl + 'api/v' + process.env.apiVersion + '/pass').then((res) => {
      commit('setList', res)
    })
  }
}
