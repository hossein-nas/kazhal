import Vue from 'vue'
import axios from 'axios'
var baseURL = 'http://kazhal.test/'

if (process.env.PROD) {
    baseURL = 'https://rp-kazhal.rp/'
}

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.headers.common['Accept'] = 'application/json'

let _axios = axios.create({
    baseURL: baseURL
})
Vue.prototype.$axios = _axios

export {
    _axios
}
