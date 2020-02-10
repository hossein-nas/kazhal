const routes = [
    {
        path: '/',
        component: () => import('layouts/MyLayout'),
        meta: { requireAuth: true },
        children: [
            { path: '', redirect: '/dashboard' },
            { path: '/dashboard', component: () => import('pages/Index') },
            // posts specifc routes ::

            { path: '/posts', component: () => import('pages/posts/Index') },
            { path: '/posts/new/post', component: () => import('pages/posts/newPost') },
            { path: '/posts/edit/post/:id/', component: () => import('pages/posts/newPost'), props: true },

            { path: '/user/preferences',
                component: () => import('pages/userPreferences/index'),
                children: [
                    { path: '', component: () => import('pages/userPreferences/userState') },
                    { path: 'change-password', component: () => import('pages/userPreferences/changePassword') },
                    { path: 'change-email', component: () => import('pages/userPreferences/changeEmail') },
                    { path: 'change-userphoto', component: () => import('pages/userPreferences/changeThumbnail') }
                ]
            },

            { path: '/user/logout', component: () => import('pages/Logout') }
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
