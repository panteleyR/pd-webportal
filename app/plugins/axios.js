export default function ({ app, $axios, $cookies, $routeri18n, $notify }, inject) {
  if (process.env.dev) {
    // Change URL only for client
    if (process.client) {
      $axios.setBaseURL(process.env.baseUrl + 'api/v' + process.env.apiVersion)
    }

    // Change URL only for server
    if (process.server) {
      $axios.setBaseURL('http://web-pd/api' + '/v' + process.env.apiVersion)
    }
  } else {
    if (process.client) {
      $axios.setBaseURL(process.env.baseUrl + 'api/v' + process.env.apiVersion)
    }

    if (process.server) {
      $axios.setBaseURL(process.env.baseUrl + 'api/v' + process.env.apiVersion)
    }
  }

  if (app.$cookies.get('access-token')) {
    $axios.defaults.headers.common.Authorization = 'Bearer ' + app.$cookies.get('access-token')
  }

  if (process.client) {
    $axios.interceptors.response.use((response) => {
      return response
    }, (error) => {
      if (error.response.status === 401) {
        app.$notify.show('Вы не авторизованы', 'error')
        app.$routeri18n.push('login')
      }

      if (error.response.status === 403) {
        app.$notify.show('У вас недостаточно прав', 'error')
      }

      if (error.response.data.appCode === 500) {
        app.$notify.show('Ошибка сервера', 'error')
      }

      if (error.response.data.appCode === 400) {
        app.$notify.show('Ошибка запроса', 'error')
      }

      if (error.response.data.appCode === 422) {
        app.$notify.show('Неверные данные', 'error')
      }

      return Promise.reject(error)
    })
  }
}
