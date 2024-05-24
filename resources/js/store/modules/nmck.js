export const nmck = {
    namespaced: true,
    state: {
        customer: {
            name: '',
            inn: '',
            kpp: '',
            order567: false,
            order450n: true,
            fz44: false,
            fz223: true,
            eaec: false,
            completed: false,
            inProgress: false,
            terminated: false,
            cancelled: false,
            endDate: null,
            endDate2: null,
            signDate: null,
            signDate2: null,
            region: '',
            noPenalties1: false,
            noPenalties2: false,
            excludedContracts: '',
            noIndexation: false,
            variationLimit: 2,
            decimalPlaces: 2
        },
        regions: []
    },
    mutations: {
        SET_CUSTOMER(state, customer) {
            Object.assign(state.customer, customer);
        },
        SET_REGIONS(state, regions) {
            state.regions = regions;
        },
        SET_ADDITIONAL_DATA(state, additionalData) {
            Object.assign(state.customer, additionalData);
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
        },
        async saveAdditionalData({ state, commit }) {
            try {
                const response = await axios.post('/api/customer/additional', state.customer);
                commit('SET_CUSTOMER', response.data);
            } catch (error) {
                console.error('Ошибка при сохранении дополнительных данных заказчика:', error);
            }
        }
    },
    getters: {
        customer: (state) => state.customer,
        regions: (state) => state.regions
    }
}
