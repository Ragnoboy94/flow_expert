export const upload = {
    namespaced: true,
    state: {
        uploadStatus: '',
        files: []
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
        }
    }
}
