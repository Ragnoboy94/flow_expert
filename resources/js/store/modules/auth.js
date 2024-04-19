import axios from 'axios';

export const auth = {
    namespaced: true,
    state: {
        loginInfo: {
            fullName: '',
            phone: '',
            password: ''
        },
        loginStep: 'inputInfo'
    },
    mutations: {
        SET_LOGIN_INFO(state, { key, value }) {
            state.loginInfo[key] = value;
        },
        SET_LOGIN_STEP(state, step) {
            state.loginStep = step;
        },
        RESET_LOGIN_INFO(state) {
            state.loginInfo = { fullName: '', phone: '', password: '' };
        }
    },
    actions: {
        async verifyUser({ commit, state }) {
            try {
                const response = await axios.post('/api/verify', {
                    fullName: state.loginInfo.fullName,
                    phone: state.loginInfo.phone
                });
                console.log(response.data);
                if (response.data.verified) {
                    commit('SET_LOGIN_STEP', 'inputPassword');
                } else {
                    console.error('User not verified');
                }
            } catch (error) {
                console.error("Error verifying user:", error);
            }
        },
        async login({ commit, state }) {
            try {
                const response = await axios.post('/api/login', state.loginInfo);
                if (response.data.success) {
                    commit('RESET_LOGIN_INFO');
                    commit('SET_LOGIN_STEP', 'inputInfo');
                } else {
                    console.error('Login failed');
                }
            } catch (error) {
                console.error("Error during login:", error);
            }
        }
    }
};
