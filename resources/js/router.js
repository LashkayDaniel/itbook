import {createRouter, createWebHistory} from 'vue-router';
import Example from "./components/Example.vue";
import NotFound from "./components/NotFound.vue";
import Dictionary from "./components/Dictionary.vue";
import Main from "./components/Main.vue";
import Admin from "./components/admin/Admin.vue";
import SignIn from "./components/auth/SignIn.vue";
import SignUp from "./components/auth/SignUp.vue";

const routes = [
    {path: '/', name: 'main', component: Main},
    {path: '/example', name: 'example', component: Example},
    {path: '/dictionary', name: 'dictionary', component: Dictionary},
    {path: '/auth/sign-in', name: 'sign-in', component: SignIn},
    {path: '/auth/sign-up', name: 'sign-up', component: SignUp},
    {path: '/admin', name: 'admin', component: Admin},


    {path: '/:pathMatch(.*)*', component: NotFound},
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('x_xsrf_token');

    if (token) {
        if (to.name === 'sign-in' || to.name === 'sign-up') {
            return next({
                name: 'main'
            })
        }
    }

    next()
})

export default router;
