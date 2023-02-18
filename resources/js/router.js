import {createRouter, createWebHistory} from 'vue-router';
import Example from "./components/Example.vue";
import NotFound from "./components/NotFound.vue";
import Main from "./components/Main.vue";
import Admin from "./components/admin/Admin.vue";
import SignIn from "./components/auth/SignIn.vue";
import SignUp from "./components/auth/SignUp.vue";

const routes = [
    {path: '/', name: 'main', component: Main},
    {path: '/example', name: 'example', component: Example},
    {path: '/auth/sign-in', name: 'sign-in', component: SignIn},
    {path: '/auth/sign-up', name: 'sign-up', component: SignUp},
    {path: '/admin', name: 'admin', component: Admin},


    {path: '/:pathMatch(.*)*', component: NotFound},
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
