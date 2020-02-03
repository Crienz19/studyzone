import axios from 'axios';

const service = {
    namespaced: true,
    state: {
        services: []
    },
    getters: {
        GET_ALL_SERVICE (state) {
            return state.services;
        },
        GET_TOTAL_REVENUE (state) {
            let revenue = 0;

            state.services.map(s => {
                revenue += s.total;
            });

            return revenue;
        },
        GET_TOTAL_ITEMS_SOLD (state) {
            let items = 0;

            state.services.map(s => {
                items += s.quantity
            });

            return items;
        },
        GET_TOTAL_TRANSACTIONS (state) {
            return state.services.length;
        }
    },
    mutations: {
        SET_SERVICES (state, payload) {
            state.services = payload;
        }
    },
    actions: {
        loadServices ({ commit }) {
            return new Promise((resolve, reject) => {
                axios.get('/api/services/getAllDailyService')
                    .then((response) => {
                        commit('SET_SERVICES', response.data);
                        resolve({
                            'message': 'Services loaded.'
                        });
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        },
        loadOverallServices ({ commit }) {
            return new Promise((resolve, reject) => {
                axios.get('/api/services/getOverallService')
                    .then((response) => {
                        commit('SET_SERVICES', response.data);
                        resolve({
                            'message':  'Services loaded.'
                        });
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        },
        addService ({ commit }, payload) {
            return new Promise((resolve, reject) => {
                axios.post('/api/services/storeService', payload)
                    .then((response) => {
                        resolve({
                            'message': 'Service Added'
                        });
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        }
    }
}

export default service;