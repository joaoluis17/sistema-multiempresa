// main.js
import axios from 'axios'
import Vue from 'vue'
import App from './App.vue'
import './assets/style.css'
import router from './router'

Vue.config.productionTip = false

axios.defaults.baseURL = 'http://localhost:8000'
axios.defaults.withCredentials = true

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')
