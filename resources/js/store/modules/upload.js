export const upload = {
    namespaced: true,
    state: {
        uploadStatus: '',
        files: [],
        offers: [],
        offerRows: [],
        monthlyData: [
            { month: 'Январь', price: 0, quantity: 0, month_id: 1 },
            { month: 'Февраль', price: 0, quantity: 0, month_id: 2 },
            { month: 'Март', price: 0, quantity: 0, month_id: 3 },
            { month: 'Апрель', price: 0, quantity: 0, month_id: 4 },
            { month: 'Май', price: 0, quantity: 0, month_id: 5 },
            { month: 'Июнь', price: 0, quantity: 0, month_id: 6 },
            { month: 'Июль', price: 0, quantity: 0, month_id: 7 },
            { month: 'Август', price: 0, quantity: 0, month_id: 8 },
            { month: 'Сентябрь', price: 0, quantity: 0, month_id: 9 },
            { month: 'Октябрь', price: 0, quantity: 0, month_id: 10 },
            { month: 'Ноябрь', price: 0, quantity: 0, month_id: 11 },
            { month: 'Декабрь', price: 0, quantity: 0, month_id: 12 },
        ],
        periodicData: [
            { period: `01.01.${new Date().getFullYear()}`, quantity: 0, period_id: 1 },
            { period: `01.04.${new Date().getFullYear()}`, quantity: 0, period_id: 2 },
            { period: `01.07.${new Date().getFullYear()}`, quantity: 0, period_id: 3 },
            { period: `01.10.${new Date().getFullYear()}`, quantity: 0, period_id: 4 }
        ]
    },
    mutations: {
        SET_UPLOAD_STATUS(state, status) {
            state.uploadStatus = status;
        },
        SET_FILES(state, files) {
            state.files = files;
        },
        SET_EXCEL_ROWS(state, { fileId, rows }) {
            const file = state.files.find(f => f.id === fileId);
            if (file) {
                file.excelRows = rows;
            }
        },
        SET_OFFERS(state, offers) {
            state.offers = offers;
        },
        SET_OFFER_ROWS(state, offerRows) {
            state.offerRows = offerRows;
        },
        UPDATE_MEDICINE_ROW(state, updatedRow) {
            const offerId = updatedRow.offer_id;
            const rows = state.offerRows[offerId] || [];
            const index = rows.findIndex(row => row.id === updatedRow.id);
            if (index !== -1) {
                state.offerRows[offerId].splice(index, 1, updatedRow);
            }
        },
        SET_MONTHLY_DATA(state, monthlyData) {
            state.monthlyData = state.monthlyData.map((item) => {
                const data = monthlyData.find((data) => data.month_id === item.month_id);
                if (data) {
                    return { ...item, price: data.price, quantity: data.quantity };
                }
                return item;
            });
        },
        SET_PERIODIC_DATA(state, periodicData) {
            state.periodicData = state.periodicData.map((item) => {
                const data = periodicData.find((data) => data.period_id === item.period_id);
                if (data) {
                    return { ...item, quantity: data.quantity };
                }
                return item;
            });
        }
    },
    actions: {
        async uploadFile({ commit }, file) {
            let formData = new FormData();
            formData.append('file', file);
            try {
                const response = await axios.post('/api/upload', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                commit('SET_UPLOAD_STATUS', 'Файл успешно добавлен!');
            } catch (error) {
                commit('SET_UPLOAD_STATUS', 'Ошибка в загрузке файла на сервер!');
            }
        },
        async fetchFiles({ commit }) {
            const response = await axios.get('/api/files');
            commit('SET_FILES', response.data);
        },
        async fetchReadyFiles({ commit }) {
            const response = await axios.post('/api/files', { 'status_id': 3 });
            commit('SET_FILES', response.data);
        },
        async fetchExcelRows({ commit }, fileId) {
            const response = await axios.get(`/api/files/${fileId}/rows`);
            const rows = response.data;

            const groupedRows = rows.reduce((acc, row) => {
                const category = row.drug_category ? row.drug_category.name : 'Без категории';
                if (!acc[category]) {
                    acc[category] = [];
                }
                acc[category].push(row);
                return acc;
            }, {});

            commit('SET_EXCEL_ROWS', { fileId, rows: groupedRows });
            return groupedRows;
        },
        async splitLotsAPI({ dispatch }, { fileId, selectedLaw }) {
            try {
                const response = await axios.post('/api/split-lots', { fileId, selectedLaw });
                await dispatch('fetchReadyFiles');
            } catch (error) {
                console.error('Ошибка при разбиении на лоты:', error);
            }
        },
        async uploadOfferFile({ commit }, formData) {
            try {
                const response = await axios.post('/api/uploadOfferFile', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                commit('SET_UPLOAD_STATUS', 'Файл успешно добавлен!');
            } catch (error) {
                commit('SET_UPLOAD_STATUS', 'Ошибка в загрузке файла на сервер!');
            }
        },
        async fetchOffers({ commit }) {
            try {
                const response = await axios.get('/api/offers');
                const offers = response.data.map(data => data.offer);
                const offerRows = response.data.reduce((acc, data) => {
                    acc[data.offer.id] = data.medicine_rows;
                    return acc;
                }, {});
                commit('SET_OFFERS', offers);
                commit('SET_OFFER_ROWS', offerRows);
            } catch (error) {
                console.error('Ошибка при получении списка предложений:', error);
            }
        },
        async updateMedicineRow({ commit }, updatedRow) {
            try {
                const response = await axios.put(`/api/medicine-rows/${updatedRow.id}`, updatedRow);
                commit('UPDATE_MEDICINE_ROW', response.data);
            } catch (error) {
                console.error('Ошибка при обновлении строки:', error);
            }
        },
        async prepareNMCKFile({ state, commit }, requestData) {
            try {
                await axios.post('/api/save-data', {
                    requestData,
                    monthlyData: state.monthlyData.map(item => ({
                        month_id: item.month_id,
                        price: item.price,
                        quantity: item.quantity
                    })),
                    periodicData: state.periodicData.map(item => ({
                        period_id: item.period_id,
                        quantity: item.quantity
                    }))
                });
                commit('SET_UPLOAD_STATUS', 'Данные успешно сохранены.');
            } catch (error) {
                console.error('Ошибка при подготовке файла НМЦК:', error);
                throw error;
            }
        },
        async fetchData({ commit }) {
            try {
                const response = await axios.get('/api/get-data');
                commit('SET_MONTHLY_DATA', response.data.monthlyData);
                commit('SET_PERIODIC_DATA', response.data.periodicData);
            } catch (error) {
                console.error('Ошибка при получении данных:', error);
            }
        },
        async deleteDemand({ dispatch }, fileId) {
            try {
                const response = await axios.delete('/api/delete-demand/' + fileId);
                await dispatch('fetchFiles');
            } catch (error) {
                console.error('Ошибка при удалении потребности:', error);
            }
        },
        async deleteOffer({ dispatch }, fileId) {
            try {
                const response = await axios.delete('/api/delete-offer/' + fileId);
                await dispatch('fetchOffers');
            } catch (error) {
                console.error('Ошибка при удалении предложения:', error);
            }
        },
    }
}
