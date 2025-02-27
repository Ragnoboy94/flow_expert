// store/modules/landing.js
import axios from 'axios';

export const landing = {
    namespaced: true,
    state: () => ({
        formData: {
            company_name: '',
            position: '',
            surname: '',
            name: '',
            phone: '',
            email: '',
            comments: '',
            agreement: false
        },
        dialogVisible: false,
        dialogMessage: '',
        dialogColor: 'green'

    }),
    mutations: {
        SET_FORM_DATA(state, payload) {
            state.formData = { ...state.formData, ...payload };
        },
        SET_DIALOG_VISIBLE(state, visible) {
            state.dialogVisible = visible;
        },
        SET_DIALOG_MESSAGE(state, message) {
            state.dialogMessage = message;
        },
        SET_DIALOG_COLOR(state, message) {
            state.dialogColor = message;
        }
    },
    actions: {
        setFormData({ commit }, payload) {
            commit('SET_FORM_DATA', payload);
        },
        async submitForm({ commit, state }) {
            try {
                state.formData.phone = state.formData.phone.replace(/[^\d]/g, '');
                const response = await axios.post('/api/inquiries', state.formData);
                console.log('Form submitted:', response.data);
                commit('SET_DIALOG_MESSAGE', 'Ваши данные успешно отправлены! В ближайшее время мы с вами свяжемся!');
                commit('SET_DIALOG_VISIBLE', true);
            } catch (error) {
                console.error('Error submitting form:', error);
                commit('SET_DIALOG_MESSAGE', 'Ошибка при отправке формы.');
                commit('SET_DIALOG_VISIBLE', true);
                commit('SET_DIALOG_COLOR', 'red');
            }
        }
    }

};
