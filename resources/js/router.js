import {createRouter, createWebHistory} from 'vue-router';
import Example from "./components/Example.vue";
import NotFound from "./components/NotFound.vue";
import Main from "./components/Main.vue";
import Login from "./components/Login.vue";

const routes = [
    {path: '/', name: 'main', component: Main},
    {path: '/example', name: 'example', component: Example},
    {path: '/login', name: 'login', component: Login},


    {path: '/:pathMatch(.*)*', component: NotFound},
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
