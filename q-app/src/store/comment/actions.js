import { _axios } from '@/boot/axios'

export async function fetchAllComments ({ commit, dispatch, }) {
    commit('SET_COMMENT_LOADING')

    let comments = await _axios.get('/api/comments?all=1')
    let trashed = await _axios.get('/api/comments?trashed=1')

    commit('SET_COMMENTS', comments.data)
    commit('SET_TRASHED', trashed.data)
    commit('SET_COMMENT_LOADING_DONE')
}

export async function approveComment ({ commit, dispatch, }, payload) {
    let type = 'post'

    if (payload.type) type = payload.type

    await _axios({
        method: type,
        url: payload.uri,
        data: {},
    })

    dispatch('fetchAllComments')
}

export async function trashComment ({ commit, dispatch, }, payload) {
    let type = 'post'

    if (payload.type) type = payload.type

    await _axios({
        method: type,
        url: payload.uri,
        data: {},
    })

    dispatch('fetchAllComments')
}

export async function approveMultipleComments ({ commit, dispatch, }, payload) {
    let uri = '/api/comments/bulk-approve'
    _axios.post(uri, { comments: payload, })
        .then(({ data, }) => {
            dispatch('fetchAllComments')
        })
}
