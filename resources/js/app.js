import './bootstrap';

import {createApp} from 'vue';

import PrimeVue from "primevue/config";
import 'primevue/resources/themes/saga-green/theme.css';
import 'primevue/resources/primevue.min.css';
import 'primeicons/primeicons.css';
import 'primeflex/primeflex.min.css'

import Button from "primevue/button";

import App from './App.vue';
import router from "./routes/index.js";
import {store} from "./store/index.js";

createApp(App).use(router).use(PrimeVue).component('Button', Button).use(store).mount("#app");
