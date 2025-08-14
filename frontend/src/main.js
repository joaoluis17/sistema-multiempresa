import axios from 'axios'
import Vue from 'vue'
import App from './App.vue'
import './assets/style.css'
import router from './router'

Vue.config.productionTip = false

axios.defaults.baseURL = process.env.VUE_APP_API_URL
axios.defaults.headers.common['Accept'] = 'application/json'
axios.defaults.headers.common['Content-Type'] = 'application/json'

axios.interceptors.request.use(config => {
  const token = localStorage.getItem('jwt_token')
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }
  return config
}, error => {
  return Promise.reject(error)
})

axios.interceptors.response.use(response => {
  return response
}, error => {
  if (error.response.status === 401) {
    router.push({ name: 'Login' })
    localStorage.removeItem('jwt_token')
  }
  return Promise.reject(error)
})

Vue.prototype.$http = axios

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')