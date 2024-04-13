import { createStore } from 'vuex';

// Определите состояние, мутации, действия и геттеры
const state = {
    // пример состояния
    count: 0
};

const mutations = {
    // пример мутации
    increment(state) {
        state.count++;
    }
};

const actions = {
    // пример действия
    increment({ commit }) {
        commit('increment');
    }
};

const getters = {
    // пример геттера
    count: state => state.count
};

export default createStore({
    state,
    mutations,
    actions,
    getters
});
