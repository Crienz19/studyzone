import axios from 'axios';

const transaction = {
    namespaced: true,
    state: {
        transactions: []
    },
    getters: {
        GET_TRANSACTIONS (state) {
            return state.transactions;
        },
        GET_TOTAL_PROFIT (state) {
            let profit = 0;
            
            state.transactions.map(data => {
                profit += data.total
            })

            return profit;
        },
        GET_TOTAL_PAX (state) {
            let pax = 0;

            state.transactions.map(data => {
                pax += data.pax
            });

            return pax;
        },
        GET_TOTAL_LOGGED_CLIENT (state) {
            return state.transactions.filter(transaction => transaction.status == 'CLOCKED IN').length
        }
    },
    mutations: {
        SET_TRANSACTIONS (state, payload) {
            state.transactions = payload;
        },
        ADD_TRANSACTION (state, payload) {
            state.transactions.unshift(payload);
        }
    },
    actions: {
        loadTransaction({ commit }) {
            return new Promise((resolve, reject) => {
                axios.get('/api/admin/getAllTransactions')
                    .then((response) => {
                        commit('SET_TRANSACTIONS', response.data);
                        resolve({
                            'message': 'Transaction Loaded.'
                        })
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        },
        loadOverallTransaction ({ commit }) {
            return new Promise((resolve, reject) => {
                axios.get('/api/admin/getOverallTransactions')
                    .then((response) => {
                        commit('SET_TRANSACTIONS', response.data);
                        resolve({
                            'message': 'Transaction Loaded.'
                        })
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        },
        async addTransaction({ commit }, transaction) {
            commit('ADD_TRANSACTION', transaction)
        },
        async deleteTransaction({ dispatch }, id) {
            return new Promise((resolve, reject) => {
                axios.get(`/api/admin/deleteTransaction/${id}`)
                    .then((response) => {
                        dispatch('loadOverallTransaction');
                        resolve({
                            'message': 'Transaction Loaded'
                        })
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        }
    }
}

export default transaction;