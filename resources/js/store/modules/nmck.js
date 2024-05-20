export const nmck = {
    namespaced: true,
    state: {
        customer: {
            name: '',
            inn: '',
            kpp: ''
        },
        regions: []
    },
    mutations: {
        SET_CUSTOMER(state, customer) {
            state.customer = customer;
        },
        SET_REGIONS(state, regions) {
            state.regions = regions;
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
        },
        async fetchRegions({ commit }) {
            try {
                const response = await axios.get('/api/regions');
                commit('SET_REGIONS', response.data);
            } catch (error) {
                console.error('Ошибка при получении данных регионов:', error);
            }
        }
    },
    getters: {
        customer: (state) => state.customer,
        regions: (state) => state.regions
    }
}
