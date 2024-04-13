import { createRouter, createWebHistory } from 'vue-router';
import Header from '../components/Header.vue';

const routes = [
    {
        path: '/home',
        name: 'Header',
        component: Header
    },
];

let process;
const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
});

export default router;
