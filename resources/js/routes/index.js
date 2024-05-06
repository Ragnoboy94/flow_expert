import {createRouter, createWebHistory} from 'vue-router';
import e404 from '../components/e404.vue'
import Landing from "../components/Landing.vue";
import Cookies from 'js-cookie';
import Unauthorized from '../components/Unauthorized.vue';
import About from "../components/About.vue";
import Contacts from "../components/Contacts.vue";
import Profile from "../components/authorized/Profile.vue";
import Demand from "../components/authorized/Demand.vue";
import UserAgreement from "../components/UserAgreement.vue";
import PrivacyPolicy from "../components/PrivacyPolicy.vue";

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
    },
    {
        path: '/about',
        name: 'About',
        component: About
    },
    {
        path: '/contacts',
        name: 'Contacts',
        component: Contacts
    },
    {
        path: '/profile',
        name: 'Profile',
        component: Profile,
        meta: { requiresAuth: true }
    },
    {
        path: '/demand',
        name: 'Demand',
        component: Demand,
        meta: { requiresAuth: true }
    },
    {
        path: '/user_agreement',
        name: 'UserAgreement',
        component: UserAgreement,
    },
    {
        path: '/privacy_policy',
        name: 'PrivacyPolicy',
        component: PrivacyPolicy,
    }

];


const router = createRouter({
    history: createWebHistory(import.meta.env.VITE_BASE_API_URL),
    routes
});

router.beforeEach(async (to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
    if (requiresAuth && !Cookies.get('access_token')) {
        next({ path: '/unauthorized', query: { redirect: to.fullPath } });
    } else {
        next();
    }
});

export default router;
