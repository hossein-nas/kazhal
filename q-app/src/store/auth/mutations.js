/*
export function someMutation (state) {
}
*/

export function SET_TOKEN (state, payload) {
    state.token = payload
    state.init = true
}

export function SET_USER (state, payload) {
    state.user = payload.user
}
