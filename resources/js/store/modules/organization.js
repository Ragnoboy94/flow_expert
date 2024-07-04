export const organization = {
    namespaced: true,
    state: {
        organization: {
            name: '',
            juridical_address: '',
            postal_address: '',
            inn: '',
            account_number: '',
            bank_account: '',
            bik: '',
            ogrn: '',
            email: '',
            phone: ''
        },
        uuid: null,
        showConfirmationModal: false,
    },
    mutations: {
        SET_ORGANIZATION_FIELD(state, { field, value }) {
            state.organization[field] = value;
        },
        RESET_ORGANIZATION(state) {
            state.organization = {
                name: '',
                juridical_address: '',
                postal_address: '',
                inn: '',
                account_number: '',
                bank_account: '',
                bik: '',
                ogrn: '',
                email: '',
                phone: ''
            };
        },
        SET_UUID(state, uuid) {
            state.uuid = uuid;
        },
        SET_CONFIRMATION_DIALOG(state, value) {
            state.showConfirmationModal = value;
        },
    },
    actions: {
        async registerOrganization({ state, commit }) {
            try {
                await axios.post('/api/organizations/register', state.organization);
                commit('RESET_ORGANIZATION');
            } catch (error) {
                console.error('Ошибка при регистрации организации:', error);
            }
        },
        setOrganizationField({ commit }, payload) {
            commit('SET_ORGANIZATION_FIELD', payload);
        },
        async confirmOrganization({ commit }, uuid) {
            try {
                await axios.get(`/api/organizations/confirm/${uuid}`);
                return true;
            } catch (error) {
                console.error('Ошибка при подтверждении организации:', error);
                return false;
            }
        },
        async setTrialPeriod({ state, commit }) {
            try {
                const response = await axios.post('/api/organizations/set-trial-period', { uuid: state.uuid });
                console.log('Trial period set:', response.data);
                commit('SET_CONFIRMATION_DIALOG', false);
            } catch (error) {
                console.error('Error setting trial period:', error);
            }
        },
        async confirmUser({}, token) {
            try {
                await axios.post(`/api/users/confirm`, { token });
                return true;
            } catch (error) {
                console.error('Ошибка при подтверждении пользователя:', error);
                return false;
            }
        },
    },
};
