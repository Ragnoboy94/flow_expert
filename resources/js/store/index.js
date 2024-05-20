import Vuex from 'vuex';

import {auth} from './modules/auth';
import {landing} from './modules/landing.js';
import {profile} from "./modules/profile.js";
import {consultation} from "./modules/consultation.js";
import {upload} from "./modules/upload.js";
import {nmck} from "./modules/nmck.js";

export const store = new Vuex.Store({
    modules: {
        auth,
        landing,
        profile,
        consultation,
        upload,
        nmck
    },
});
