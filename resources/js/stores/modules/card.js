import axios from 'axios';

const card = {
    namespaced: true,
    state: {
        cards: []
    },
    getters: {
        GET_CARDS (state) {
            return state.cards;
        },
        GET_TOTAL_SOLD_CARDS (state) {
            let sold = 0;

            state.cards.map(card => {
                sold =+ card.price
            })

            return sold;
        },
        GET_TOTAL_NO_OF_CARDS (state) {
            return state.cards.length;
        },
        GET_TOTAL_NO_OF_ACTIVE_CARDS (state) {
            return state.cards.filter(card => card.status == true).length;
        }
    },
    mutations: {
        SET_CARDS (state, payload) {
            state.cards = payload;
        }
    },
    actions: {
        loadCards ({ commit }) {
            return new Promise((resolve, reject) => {
                axios.get('/api/card/getAllCards')
                    .then((response) => {
                        commit('SET_CARDS', response.data);
                        resolve({
                            'message': 'Card Loaded'
                        })
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
        addCard ({ commit }, payload) {
            return new Promise((resolve, reject) => {
                axios.post('/api/card/storeCard', payload)
                    .then((response) => {
                        resolve({
                            'message': 'Card Added.'
                        })
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        },
        deleteCard ({ dispatch }, payload) {
            return new Promise((resolve, reject) => {
                axios.delete(`/api/card/deleteCard/${payload.id}`)
                    .then((response) => {
                        resolve({
                            'message': 'Card deleted.'
                        })
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        }
    }
}

export default card;