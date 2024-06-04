export const upload = {
    namespaced: true,
    state: {
        uploadStatus: '',
        files: [],
        offers: [],
        offerRows: []
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
            const response = await axios.post('/api/files', {'status_id': 3});
            commit('SET_FILES', response.data);
        },
        async fetchExcelRows({ commit }, fileId) {
            const response = await axios.get(`/api/files/${fileId}/rows`);
            commit('SET_EXCEL_ROWS', { fileId, rows: response.data });
            return response.data;
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
        async prepareNMCKFile({ }, requestData) {
            try {
                const response = await axios.get('/api/drug-price', requestData);
                console.log('Ответ сервера:', response.data);
            } catch (error) {
                console.error('Ошибка при подготовке файла НМЦК:', error);
                throw error;
            }
        },
        async deleteDemand({ dispatch }, fileId) {
            try {
                const response = await axios.delete('/api/delete-demand/' + fileId);
                await dispatch('fetchFiles');
            } catch (error) {
                console.error('Ошибка при разбиении на лоты:', error);
            }
        },
    }
}
