import './bootstrap';

import {createApp} from 'vue';

import PrimeVue from "primevue/config";
import 'primevue/resources/themes/saga-green/theme.css';
import 'primevue/resources/primevue.min.css';
import 'primeicons/primeicons.css';

import App from './App.vue';
import router from "./routes/index.js";
import {store} from "./store/index.js";

createApp(App).use(router).use(PrimeVue).use(store).mount("#app");
