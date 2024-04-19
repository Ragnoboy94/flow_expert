import Vuex from 'vuex';

import {auth} from './modules/auth';

export const store = new Vuex.Store({
    modules: {
        auth,
    },
});
