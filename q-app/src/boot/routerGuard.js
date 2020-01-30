// import something here
let auth = {
    loggedIn () {
        return true
    }
}
export default async ({ app, router, Vue, store }) => {
    router.beforeEach((to, from, next) => {
        if (to.matched.some(record => record.meta.requireAuth)) {
            if (!auth.loggedIn()) {
                return next({
                    path: '/login',
                    query: { redirect: to.fullPath }
                })
            }
        }
        return next()
    })
}
