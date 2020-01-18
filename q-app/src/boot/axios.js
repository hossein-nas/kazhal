import Vue from 'vue'
import axios from 'axios'

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
let _axios = axios.create({
    baseURL: 'http://kazhal.test/'
})
Vue.prototype.$axios = _axios
