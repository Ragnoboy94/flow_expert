import './bootstrap';

import {createApp} from 'vue';

import PrimeVue from "primevue/config";
import 'primevue/resources/themes/aura-light-green/theme.css';
import 'primevue/resources/primevue.min.css';
import 'primeicons/primeicons.css';
import 'primeflex/primeflex.min.css';
import VueTheMask from 'vue-the-mask';
import ToastService from "primevue/toastservice";

import Button from "primevue/button";

import App from './App.vue';
import router from "./routes/index.js";
import {store} from "./store/index.js";

createApp(App).use(router).use(PrimeVue).use(VueTheMask).component('Button', Button).use(ToastService).use(store).mount("#app");
