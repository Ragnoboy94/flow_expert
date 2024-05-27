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
            const index = state.offerRows.findIndex(row => row.id === updatedRow.id);
            if (index !== -1) {
                state.offerRows.splice(index, 1, updatedRow);
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
                const { offer, medicine_rows } = response.data;

                if (offer) {
                    commit('SET_OFFERS', [offer]);
                }
                if (medicine_rows) {
                    commit('SET_OFFER_ROWS', medicine_rows);
                }
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
                const response = await axios.post('/api/prepare-nmck-file', requestData);
                console.log('Ответ сервера:', response.data);
            } catch (error) {
                console.error('Ошибка при подготовке файла НМЦК:', error);
                throw error;
            }
        }
    }
}
