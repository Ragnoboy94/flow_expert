import Vuex from 'vuex';

import {auth} from './modules/auth';
import {landing} from './modules/landing.js';

export const store = new Vuex.Store({
    modules: {
        auth,
        landing
    },
});
