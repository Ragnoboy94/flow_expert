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
import DownloadHistory from "../components/authorized/DownloadHistory.vue";
import Instructions from "../components/Instructions.vue";
import OrderConsultation from "../components/instructions/OrderConsultation.vue";
import AboutCompany from "../components/instructions/AboutCompany.vue";
import Register from "../components/instructions/Register.vue";
import ForgotPassword from "../components/instructions/ForgotPassword.vue";
import Procedures from "../components/instructions/Procedures.vue";
import InitialNeeds from "../components/instructions/InitialNeeds.vue";
import AuctionLots from "../components/instructions/AuctionLots.vue";
import CalculateNmck from "../components/instructions/CalculateNmck.vue";
import setComers from "../components/instructions/SetComers.vue";
import setParametersNmck from "../components/instructions/SetParametersNmck.vue";
import getJustificationNmck from "../components/instructions/GetJustificationNmck.vue";
import viewFiles from "../components/instructions/ViewFiles.vue";
import AgreePersonal from "../components/AgreePersonal.vue";
import Lots from "../components/authorized/Lots.vue";
import Offers from "../components/authorized/Offers.vue";
import NmckHistory from "../components/authorized/NmckHistory.vue";
import NmckBasis from "../components/authorized/NmckBasis.vue";
import Forbidden from "../components/Forbidden.vue";
import NotPaid from "../components/NotPaid.vue";

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
        path: '/forbidden',
        name: 'Forbidden',
        component: Forbidden
    },
    {
        path: '/not_paid',
        name: 'NotPaid',
        component: NotPaid
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
        meta: {requiresAuth: true}
    },
    {
        path: '/demand',
        name: 'Demand',
        component: Demand,
        meta: {requiresAuth: true, forbiddenPositions: [3, 4], forbiddenOrganization: true}
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
    },
    {
        path: '/download_history',
        name: 'DownloadHistory',
        component: DownloadHistory,
    },
    {
        path: '/agree_personal',
        name: 'AgreePersonal',
        component: AgreePersonal,
    },
    {
        path: '/lots',
        name: 'Lots',
        component: Lots,
        meta: {requiresAuth: true, forbiddenPositions: [2], forbiddenOrganization: true}
    },
    {
        path: '/offers',
        name: 'Offers',
        component: Offers,
        meta: {requiresAuth: true, forbiddenPositions: [2, 3, 4], forbiddenOrganization: true}
    },
    {
        path: '/nmck_history',
        name: 'NmckHistory',
        component: NmckHistory,
        meta: {requiresAuth: true}
    },
    {
        path: '/nmck_basis',
        name: 'NmckBasis',
        component: NmckBasis,
        meta: {requiresAuth: true, forbiddenPositions: [2, 3, 4], forbiddenOrganization: true}
    },


    /*
    Блок инструкций
     */
    {
        path: '/instructions',
        name: 'Instructions',
        component: Instructions,
        meta: {requiresAuth: true}
    },
    {
        path: '/instruction/order_consultation',
        name: 'OrderConsultation',
        component: OrderConsultation,
        meta: {requiresAuth: true}
    },
    {
        path: '/instruction/about_company',
        name: 'AboutCompany',
        component: AboutCompany,
        meta: {requiresAuth: true}
    },
    {
        path: '/instruction/register',
        name: 'Register',
        component: Register,
        meta: {requiresAuth: true}
    },
    {
        path: '/instruction/forgot_password',
        name: 'ForgotPassword',
        component: ForgotPassword,
        meta: {requiresAuth: true}
    },
    {
        path: '/instruction/procedures',
        name: 'Procedures',
        component: Procedures,
        meta: {requiresAuth: true}
    },
    {
        path: '/instruction/initial_needs',
        name: 'InitialNeeds',
        component: InitialNeeds,
        meta: {requiresAuth: true}
    }, {
        path: '/instruction/auction_lots',
        name: 'AuctionLots',
        component: AuctionLots,
        meta: {requiresAuth: true}
    },
    {
        path: '/instruction/calculate_nmck',
        name: 'CalculateNmck',
        component: CalculateNmck,
        meta: {requiresAuth: true}
    },
    {
        path: '/instruction/set_comers',
        name: 'setComers',
        component: setComers,
        meta: {requiresAuth: true}
    },
    {
        path: '/instruction/set_parameters_nmck',
        name: 'setParametersNmck',
        component: setParametersNmck,
        meta: {requiresAuth: true}
    },
    {
        path: '/instruction/get_justification_nmck',
        name: 'getJustificationNmck',
        component: getJustificationNmck,
        meta: {requiresAuth: true}
    },
    {
        path: '/instruction/view_files',
        name: 'viewFiles',
        component: viewFiles,
        meta: {requiresAuth: true}
    },

];


const router = createRouter({
    history: createWebHistory(import.meta.env.VITE_BASE_API_URL),
    routes
});

router.beforeEach(async (to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
    const forbiddenPositions = to.meta.forbiddenPositions || [];
    const userPosition = Cookies.get('position') ? JSON.parse(Cookies.get('position')).id : null;
    const forbiddenOrganization = to.matched.some(record => record.meta.forbiddenOrganization);

    if (requiresAuth && !Cookies.get('access_token')) {
        next({path: '/unauthorized', query: {redirect: to.fullPath}});
    } else if (forbiddenOrganization && Cookies.get('organization_status_id') === '3') {
        next({path: '/not_paid', query: {redirect: to.fullPath}});
    } else if (forbiddenPositions.includes(userPosition)) {
        next({path: '/forbidden', query: {redirect: to.fullPath}});
    } else {
        next();
    }
});

export default router;
