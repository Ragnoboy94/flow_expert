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
        }
    }
}
