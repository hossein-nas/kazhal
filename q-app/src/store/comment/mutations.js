/*
export function someMutation (state) {
}
*/

export function SET_COMMENTS (state, comments) {
    state.comments = comments
}

export function SET_COMMENT_LOADING_DONE (state) {
    state.loading = true
}
export function SET_COMMENT_LOADING (state) {
    state.loading = false
}
