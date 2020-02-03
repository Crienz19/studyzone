import axios from 'axios';

const space = {
    namespaced: true,
    state: {
        spaces: []
    },
    getters: {
        GET_ALL_SPACES (state) {
            return state.spaces;
        }
    },
    mutations: {
        SET_SPACES (state, payload) {
            state.spaces = payload;
        }
    },
    actions: {
        loadSpaces ({ commit }) {
            return new Promise((resolve, reject) => {
                axios.get('/api/space/getAll')
                    .then((response) => {
                        commit('SET_SPACES', response.data);
                        resolve({
                            'message': 'Spaces loaded.'
                        })
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
        addSpace ({ commit }, payload) {
            return new Promise((resolve, reject) => {
                axios.post('/api/space/store', payload)
                    .then((response) => {
                        resolve({
                            'message': 'Space Added.'
                        })
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        },
        updateSpace ({ commit }, payload) {
            return new Promise((resolve, reject) => {
                axios.patch(`/api/space/update/${payload.id}`, payload)
                    .then((response) => {
                        resolve({
                            'message': 'Space Updated.'
                        })
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        },
        deleteSpace ({ commit }, payload) {
            return new Promise((resolve, reject) => {
                axios.delete(`/api/space/delete/${payload.id}`)
                    .then((response) => {
                        resolve({
                            'message': 'Space Deleted.'
                        })
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        }
    }
}

export default space;