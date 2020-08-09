import { _axios } from '../../boot/axios'
/*
export function someAction (context) {
}
*/

export async function init ({ commit, dispatch, }, payload) {
    let credentials = payload.data
    let data = null
    await _axios.post('/api/login', credentials).then(response => {
        data = response.data
    })

    commit('SET_TOKEN', data.access_token)

    dispatch('setAxiosHeader', data.access_token)
    dispatch('setTokenLocalStorage', data.access_token)
}

export function setToken ({ commit, }, token) {
    commit('SET_TOKEN', token)
}

export function setUserInfo ({ commit, }, user) {
    commit('SET_USER', user)
}

export function setAxiosHeader ({ commit, }, payload) {
    if (payload !== null) {
        _axios.defaults.headers.common['Authorization'] = ` Bearer ${payload}`

        return
    }

    _axios.defaults.headers.common['Authorization'] = null
}

export function setTokenLocalStorage ({ commit, }, payload) {
    if (payload !== null) {
        localStorage.setItem('token', payload)
    } else {
        localStorage.removeItem('token')
    }
}
