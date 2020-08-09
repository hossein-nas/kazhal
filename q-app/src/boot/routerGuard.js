import auth from './authUser'

export default async ({ app, router, Vue, store, }) => {
    router.beforeEach(async (to, from, next) => {
        if (to.matched.some(record => record.meta.requireAuth)) {
            let LoggedIn = false

            try {
                await auth(store)
                LoggedIn = true
            } catch (e) {
            }

            if (!LoggedIn) {
                return next({
                    path: '/login',
                    query: { redirect: to.fullPath, },
                })
            }
        }

        return next()
    })
}
