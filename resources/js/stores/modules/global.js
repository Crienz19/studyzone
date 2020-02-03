const global = {
    namespaced: true,
    state: {
        layout: ''
    },
    getters: {
        GET_LAYOUT (state) {
            return state.layout;
        }
    },
    mutations: {
        SET_LAYOUT (state, payload) {
            state.layout = payload;
        }
    },
    actions: {
        async setLayout ({ commit }, layout) {
            commit('SET_LAYOUT', layout);
        }
    }
}

export default global;