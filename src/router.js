import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'

Vue.use(Router);

let router = new Router({
    routes: [
        {
            path     : '/',
            name     : 'home',
            component: Home,
        },
        {
            path     : '/admin',
            name     : 'admin',
            meta     : {
                requiresAuth: true,
            },
            // route level code-splitting
            // this generates a separate chunk (about.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () => import(/* webpackChunkName: "admin" */ './views/Admin.vue')
        }
    ]
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        axios.get("validate.php")
             .then((response) => {
                 if (response.data === 0) {
                     next();
                 } else {
                     next({path: "/"})
                 }
             })
    } else {
        next();
    }
});
export default router;
