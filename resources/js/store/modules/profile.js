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
        }
    }),
    mutations: {
        SET_USER_DATA(state, payload) {
            state.user = payload;
        },
        UPDATE_USER_FIELD(state, { key, value }) {
            if (state.user.hasOwnProperty(key)) {
                state.user[key] = value;
            }
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
                alert('Профиль успешно обновлен!');
            } catch (error) {
                console.error("Error updating user data:", error);
                alert('Ошибка обновления профиля!');
            }
        }
    },
    getters: {
        userInfo: state => state.user
    }
};
