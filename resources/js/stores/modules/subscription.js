import axios from 'axios';

const subscription = {
    namespaced: true,
    state: {
        subscriptions: []
    },
    getters: {
        GET_SUBSCRIPTIONS (state) {
            return state.subscriptions;
        },
        GET_TOTAL_NO_OF_SUBSCRIPTIONS (state) {
            return state.subscriptions.length;
        },
        GET_TOTAL_REVENUE (state) {
            let revenue = 0;

            state.subscriptions.map(sub => {
                revenue += sub.price
            });

            return revenue;
        },
        GET_TOTAL_ACTIVE_SUBSCRIPTIONS (state) {
            return state.subscriptions.filter(sub => sub.status == true).length
        }
    },
    mutations: {
        SET_SUBSCRIPTIONS (state, payload) {
            state.subscriptions = payload;
        }
    },
    actions: {
        async loadSubscriptions ({ commit }) {
            await axios.get('/api/subscription/getAllSubs')
                .then((response) => {
                    commit('SET_SUBSCRIPTIONS', response.data);
                })
        },
        async deleteSubscription ({ dispatch }, payload) {
            await axios.delete(`/api/subscription/deleteSubscription/${payload.id}`)
                .then((response) => {
                    dispatch('loadSubscriptions');
                })
        }
    }
}

export default subscription;