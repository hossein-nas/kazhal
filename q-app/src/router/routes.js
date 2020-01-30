const routes = [
    {
        path: '/',
        component: () => import('layouts/MyLayout.vue'),
        children: [{ path: '', component: () => import('pages/Index.vue') }],
        meta: { requireAuth: true }
    },
    {
        path: '/',
        component: () => import('layouts/MyLayout'),
        children: [
            { path: '/dashboard', component: () => import('pages/Index'), meta: { requireAuth: true } },

            { path: '/user/preferences', component: () => import('pages/userPreferences'), meta: { requireAuth: true } },
            { path: '/user/logout', component: () => import('pages/Logout'), meta: { requireAuth: true } }
        ]
    },
    {
        path: '/login',
        component: () => import('layouts/Login'),
        name: 'login'
    }
]

// Always leave this as last one
if (process.env.MODE !== 'ssr') {
    routes.push({
        path: '*',
        component: () => import('pages/Error404.vue')
    })
}

export default routes
