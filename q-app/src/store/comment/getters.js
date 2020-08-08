/*
export function someGetter (state) {
}
*/

export function allComments (state) {
    return state.comments
}

export function allTrashed (state) {
    return state.trashed
}

export function isLoading (state) {
    return state.loading
}

export function unapprovedComments (state) {
    return state.comments.filter(comment => !comment.verified)
}

export function approvedComments (state) {
    return state.comments.filter(comment => comment.verified)
}

export function unapprovedCount (state, getters) {
    return getters.unapprovedComments.length
}

export function approvedCount (state, getters) {
    return getters.approvedComments.length
}

export function approvedCommentsByUser (state, getters, rootState) {
    let user = rootState.auth.user

    return state.comments.filter(comment => comment.verified_by === user.id)
}

export function approvedByUserCount (state, getters) {
    return getters.approvedCommentsByUser.length
}

export function userSentComments (state, getters, rootState) {
    let user = rootState.auth.user

    return state.comments.filter(comment => comment.user_id === user.id)
}

export function userSentCommentsCount (state, getters) {
    return getters.userSentComments.length
}

export function commentsLoaded (state) {
    return state.loading
}
