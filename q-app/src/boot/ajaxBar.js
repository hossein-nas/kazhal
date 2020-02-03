import { LoadingBar } from 'quasar'

// "async" is optional
export default async ({ app, router, Vue }) => {
    router.beforeEach((to, from, next) => {
        LoadingBar.start(0)
        next()
    })
    router.afterEach(() => {
        LoadingBar.stop()
    })
}
