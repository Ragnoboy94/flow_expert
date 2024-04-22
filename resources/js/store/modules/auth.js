import axios from 'axios';
import Cookies from 'js-cookie';

export const auth = {
    namespaced: true,
    state: {
        loginInfo: {
            fullName: '',
            phone: '',
            password: ''
        },
        registerInfo: {
            fullName: '',
            phone: '',
            email: '',
            password: '',
            password_confirmation: ''
        },
        loginStep: 'inputInfo',
        isAuthenticated: false,
    },
    mutations: {
        SET_LOGIN_INFO(state, {key, value}) {
            state.loginInfo[key] = value;
        },
        SET_LOGIN_STEP(state, step) {
            state.loginStep = step;
        },
        RESET_LOGIN_INFO(state) {
            state.loginInfo = {fullName: '', phone: '', password: ''};
        },
        SET_REGISTER_INFO(state, {key, value}) {
            state.registerInfo[key] = value;
        },
        RESET_REGISTER_INFO(state) {
            state.registerInfo = {fullName: '', email: '', password: '', confirmPassword: ''};
        },
        SET_AUTHENTICATED(state, value) {
            state.isAuthenticated = value;
        },
        RESET_AUTH(state) {
            state.loginInfo = {fullName: '', phone: '', password: ''};
            state.registerInfo = {fullName: '', email: '', phone: '', password: '', confirmPassword: ''};
            state.isAuthenticated = false;
        },
        TOGGLE_LOGIN_DIALOG(state, value) {
            state.showLoginDialog = value;
        },
    },
    actions: {
        async verifyUser({commit, state}) {
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
        async login({commit, state}) {
            try {
                const response = await axios.post('/api/login', state.loginInfo);
                commit('RESET_LOGIN_INFO');
                commit('SET_LOGIN_STEP', 'loginSuccess');
                Cookies.remove('access_token');
                axios.defaults.headers.common['Authorization'] = '';

                let access_token = 'Bearer ' + response.data.access_token;
                Cookies.set('access_token', access_token, {expires: 1});
                axios.defaults.headers.common['Authorization'] = access_token;
                commit('SET_AUTHENTICATED', true);
                this.showLoginDialog = false;
            } catch (error) {
                console.error("Error during login:", error);
            }
        },
        Logout(store) {
            return new Promise((resolve, reject) => {
                Cookies.remove('access_token');
                axios.post('/api/logout')
                    .then((resp) => {
                        commit('RESET_AUTH');
                        axios.defaults.headers.common['Authorization'] = '';
                        window.location.href = '/';
                        resolve();
                    })
                    .catch((err) => {
                        console.error("Error during logout:", error);
                    });
            })
        },
        async register({commit, state}) {
            try {
                const response = await axios.post('/api/register', state.registerInfo);
                if (response.data.success) {
                    commit('RESET_REGISTER_INFO');
                    alert('Registration successful');
                    commit('SET_LOGIN_STEP', 'inputPassword');
                } else {
                    alert('Registration failed');
                }
            } catch (error) {
                console.error("Error during registration:", error);
            }
        }
    }
};
