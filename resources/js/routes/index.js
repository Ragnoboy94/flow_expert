import {createRouter, createWebHistory} from 'vue-router';
import e404 from '../components/e404.vue'
import Landing from "../components/Landing.vue";
import Cookies from 'js-cookie';
import Unauthorized from '../components/Unauthorized.vue';

const routes = [
    {
        path: '/',
        name: 'Landing',
        component: Landing,
        //meta: { requiresAuth: true }
    },
    {
        path: '/:pathMatch(.*)*',
        name: '404',
        component: e404,
    },
    {
        path: '/unauthorized',
        name: 'Unauthorized',
        component: Unauthorized
    }
];


const router = createRouter({
    history: createWebHistory(import.meta.env.VITE_BASE_API_URL),
    routes
});

router.beforeEach(async (to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
    if (requiresAuth && !Cookies.get('access_token')) {
        next('Unauthorized');
    } else {
        next();
    }
});

export default router;
