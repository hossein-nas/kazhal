
export default async ({ router, store, Vue, redirect }) => {
    router.beforeEach((to, from, next) => {
        if (to.name === 'login') {
            let payload = { access_token: localStorage.getItem('token') }
            store.dispatch('auth/checkAuthorized', payload).then(data => {
                if (data === true) { return next({ path: '/dashboard' }) }
                return next()
            }).catch(() => {
                next()
            })
            return
        }
        next()
    })
}
