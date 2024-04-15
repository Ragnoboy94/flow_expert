import { createRouter, createWebHistory } from 'vue-router';
import Header from '../components/Header.vue';
import e404 from '../components/e404.vue'

const routes = [
    {
        path: '/',
        name: 'Header',
        component: Header
    },
    {
        path: '/:pathMatch(.*)*',
        name: '404',
        component: e404,
    },
];


const router = createRouter({
    history: createWebHistory(import.meta.env.VITE_BASE_API_URL),
    routes
});

export default router;
