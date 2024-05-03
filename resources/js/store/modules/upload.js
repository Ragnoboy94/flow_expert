export const upload = {
    namespaced: true,
    state: {
        uploadStatus: ''
    },
    mutations: {
        SET_UPLOAD_STATUS(state, status) {
            state.uploadStatus = status;
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
                commit('SET_UPLOAD_STATUS', 'File uploaded successfully');
                console.log(response.data);
            } catch (error) {
                commit('SET_UPLOAD_STATUS', 'Error uploading file');
                console.error(error);
            }
        }
    }
}
