const routes = [
    {
        path: '/',
        component: () => import('layouts/MyLayout.vue'),
        children: [{ path: '', component: () => import('pages/Index.vue') }]
    },
    {
        path: '/test',
        component: () => import('layouts/MyLayout'),
        name: 'test',
        children: [
            { path: '', component: () => import('pages/test') },
            { path: 'hey', component: () => import('pages/hey') }
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
