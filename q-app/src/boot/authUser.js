import { _axios } from './axios'

export default function (store) {
    return new Promise((resolve, reject) => {
        if (localStorage.getItem('token')) {
            var token = localStorage.getItem('token')
            _axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
        }
        _axios.get('api/user')
            .then((res) => {
                store.dispatch('auth/setToken', token)
                store.dispatch('auth/setUserInfo', res.data)
                resolve()
            })
            .catch((e) => {
                reject()
            })
    })
}
