import axios from 'axios';

export const profile = {
    namespaced: true,
    state: () => ({
        user: {
            fullName: '',
            position: '',
            company: '',
            inn: '',
            kpp: '',
            phone: '',
            email: ''
        },
        dialogProfileVisible: false,
        dialogProfileMessage: '',
        dialogProfileColor: 'green'
    }),
    mutations: {
        SET_USER_DATA(state, payload) {
            state.user = payload;
        },
        UPDATE_USER_FIELD(state, { key, value }) {
            if (state.user.hasOwnProperty(key)) {
                state.user[key] = value;
            }
        },
        SET_DIALOG_PROFILE_VISIBLE(state, visible) {
            state.dialogProfileVisible = visible;
        },
        SET_DIALOG_PROFILE_MESSAGE(state, message) {
            state.dialogProfileMessage = message;
        },
        SET_DIALOG_PROFILE_COLOR(state, message) {
            state.dialogProfileColor = message;
        }
    },
    actions: {
        async fetchUserData({ commit }) {
            try {
                const response = await axios.get('/api/profile');
                commit('SET_USER_DATA', response.data);
            } catch (error) {
                console.error("Error fetching user data:", error);
            }
        },
        async updateUserData({ commit, state }) {
            try {
                const response = await axios.post('/api/profile/update', state.user);
                commit('SET_USER_DATA', state.user);
                commit('SET_DIALOG_PROFILE_MESSAGE', 'Все изменения сохранены!');
                commit('SET_DIALOG_PROFILE_VISIBLE', true);
            } catch (error) {
                console.error("Error updating user data:", error);
                commit('SET_DIALOG_PROFILE_MESSAGE', 'Ошибка обновления профиля!');
                commit('SET_DIALOG_PROFILE_VISIBLE', true);
                commit('SET_DIALOG_PROFILE_COLOR', 'red');
            }
        }
    },
    getters: {
        userInfo: state => state.user
    }
};
