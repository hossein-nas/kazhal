import Vue from 'vue'
import axios from 'axios'
var baseURL = ''

if (process.env.PROD) {
    console.log('PROD')
    baseURL = 'https://rp-kazhal.ir/'
}

if (process.env.DEV) {
    console.log('DEV')
    baseURL = 'http://kazhal.test/'
}

window.baseURL = baseURL

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.headers.common['Accept'] = 'application/json'

let _axios = axios.create({
    baseURL: baseURL,
})
Vue.prototype.$axios = _axios

export {
    _axios
}
