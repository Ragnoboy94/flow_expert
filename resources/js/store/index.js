import Vuex from 'vuex';

import {auth} from './modules/auth';
import {landing} from './modules/landing.js';
import {profile} from "./modules/profile.js";
import {consultation} from "./modules/consultation.js";

export const store = new Vuex.Store({
    modules: {
        auth,
        landing,
        profile,
        consultation
    },
});
