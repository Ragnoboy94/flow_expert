export const nmck = {
    namespaced: true,
    state: {
        customer: {
            name: '',
            inn: '',
            kpp: ''
        }
    },
    mutations: {
        SET_CUSTOMER(state, customer) {
            state.customer = customer;
        }
    },
    actions: {
        async fetchCustomer({ commit }) {
            try {
                const response = await axios.get('/api/customer');
                commit('SET_CUSTOMER', response.data);
            } catch (error) {
                console.error('Ошибка при получении данных заказчика:', error);
            }
        },
        async updateCustomer({ commit }, customer) {
            try {
                const response = await axios.post('/api/customer', customer);
                commit('SET_CUSTOMER', response.data);
            } catch (error) {
                console.error('Ошибка при обновлении данных заказчика:', error);
            }
        }
    },
    getters: {
        customer: (state) => state.customer
    }
}
