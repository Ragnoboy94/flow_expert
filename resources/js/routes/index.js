import {createRouter, createWebHistory} from 'vue-router';
import e404 from '../components/e404.vue'
import Landing from "../components/Landing.vue";

const routes = [
    {
        path: '/',
        name: 'Landing',
        component: Landing
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
