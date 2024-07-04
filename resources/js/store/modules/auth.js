import axios from 'axios';
import Cookies from 'js-cookie';

const categories = [
    {key: 1, name: 'регионального министерства или комитета здравоохранения'},
    {key: 2, name: 'аптечной сети федерального или регионального уровня'},
    {key: 3, name: 'частной клиники'},
    {key: 4, name: 'государственного учреждения здравоохранения'},
];
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
            password_confirmation: '',
            category_id: 3,
            position_id: null,
            organization_id: null
        },
        categories: categories,
        loginStep: 'inputInfo',
        isAuthenticated: false,
        dialogRegistrationMessage: '',
        dialogRegistrationColor: 'green',
        dialogRegistrationVisible: false,
        loginErrorText: '',
        organizations: [],
        positions: [],
        position: Cookies.get('position') ? JSON.parse(Cookies.get('position')) : null,
    },
    mutations: {
        SET_LOGIN_ERROR_TEXT(state, text) {
            state.loginErrorText = text;
        },
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
            state.registerInfo = {fullName: '', phone: '', email: '', password: '', confirmPassword: ''};
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
        SET_DIALOG_REGISTRATION_MESSAGE(state, message) {
            state.dialogRegistrationMessage = message;
        },
        SET_DIALOG_REGISTRATION_COLOR(state, message) {
            state.dialogRegistrationColor = message;
        },
        SET_DIALOG_REGISTRATION_VISIBLE(state, visible) {
            state.dialogRegistrationVisible = visible;
        },
        SET_SELECTED_ORGANIZATION(state, organization) {
            state.selectedOrganization = organization;
        },
        SET_POSITIONS(state, positions) {
            state.positions = positions;
        },
        SET_ORGANIZATIONS(state, organizations) {
            state.organizations = organizations;
        },
        SET_POSITION(state, position) {
            state.position = position;
            Cookies.set('position', JSON.stringify(position));
        },
    },
    actions: {
        async checkAuthentication({commit}) {
            const accessToken = Cookies.get('access_token');
            if (accessToken) {
                commit('SET_AUTHENTICATED', true);
            } else {
                commit('SET_AUTHENTICATED', false);
            }
        },
        async verifyUser({commit, state}) {
            try {
                const response = await axios.post('/api/verify', {
                    fullName: state.loginInfo.fullName,
                    phone: state.loginInfo.phone.replace(/[^\d]/g, '')
                });
                if (response.data.verified) {
                    commit('SET_LOGIN_STEP', 'inputPassword');
                }
            } catch (error) {
                commit('SET_LOGIN_ERROR_TEXT', error.response.data.message);
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
                commit('SET_POSITION', response.data.position);
                Cookies.set('organization_status_id', response.data.organization_status_id);
                this.showLoginDialog = false;
            } catch (error) {
                commit('SET_LOGIN_ERROR_TEXT', 'Ошибка авторизации: неверный логин или пароль');
            }
        },
        Logout({store, commit}) {
            return new Promise((resolve, reject) => {
                Cookies.remove('access_token');
                axios.post('/api/logout')
                    .then((resp) => {
                        axios.defaults.headers.common['Authorization'] = '';
                        commit('SET_AUTHENTICATED', false);
                        commit('SET_LOGIN_STEP', 'inputInfo');
                        resolve();
                    })
                    .catch((err) => {
                        console.error("Error during logout:", err);
                    });
            })
        },
        async register({commit, state}) {
            try {
                const response = await axios.post('/api/register', state.registerInfo);
                if (response.data.success) {
                    commit('SET_DIALOG_REGISTRATION_MESSAGE', 'Вы успешно зарегистрировались! Дождитесь подтверждения от организации!');
                    commit('SET_DIALOG_REGISTRATION_COLOR', 'green');
                    commit('SET_DIALOG_REGISTRATION_VISIBLE', true);
                    commit('RESET_REGISTER_INFO');
                    this.showLoginDialog = false;
                }
            } catch (error) {
                commit('SET_DIALOG_REGISTRATION_MESSAGE', 'Ошибка при регистрации.');
                console.log(error.response.data.message);
                commit('SET_DIALOG_REGISTRATION_COLOR', 'red');
                commit('SET_DIALOG_REGISTRATION_VISIBLE', true);
            }
        },
        async fetchPositions({ commit, state }) {
            try {
                const response = await axios.get(`/api/organizations/${state.registerInfo.organization_id}/positions`);
                commit('SET_POSITIONS', response.data);
            } catch (error) {
                console.error("Error fetching positions:", error);
            }
        },
        async fetchOrganizations({commit}) {
            try {
                const response = await axios.get('/api/organizations');
                commit('SET_ORGANIZATIONS', response.data);
            } catch (error) {
                console.error("Error fetching organizations:", error);
            }
        },
    }
};
