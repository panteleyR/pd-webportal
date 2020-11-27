export const state = () => ({
  list: []
})

export const getters = {
  list: (state) => {
    return state.list
  }
}

export const mutations = {
  setList (state, payload) {
    state.list = payload
  }
}

export const actions = {
  getAll ({ commit }) {
    return this.$axios.$get('/addresses').then((res) => {
      commit('setList', res)
    })
  }
}
