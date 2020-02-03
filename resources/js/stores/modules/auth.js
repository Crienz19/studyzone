import axios from 'axios';

const auth = {
    namespaced: true,
    state: {
        user: []
    },
    getters: {
        isAuthenticated (state) {
            if (state.user) {
                return true;
            } else {
                return false;
            }
        }
    },
    mutations: {
        SET_AUTH (state, payload) {
            state.user = payload;
        }
    },
    actions: {
        login ({ commit },formData) {
            return new Promise((resolve, reject) => {
                axios.post('/api/auth/login', formData)
                    .then((response) => {
                        commit('SET_AUTH', response.data.data);
                        localStorage.setItem('access_token', response.data.meta.token);
                        resolve(response)
                    })
                    .catch(error => {
                        commit('SET_AUTH', [])
                        reject(error);
                    })
            })
        },
        register ({ commit }, formData) {
            return new Promise((resolve, reject) => {
                axios.post('/api/auth/register', formData)
                    .then((response) => {
                        resolve({
                            'message': 'User details registered.'
                        })
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        },
        logout ({ commit }) {
            return new Promise((resolve, reject) => {
                axios.get('/api/auth/logout', {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('access_token')}`
                    }
                })
                    .then((response) => {
                        localStorage.removeItem('access_token');
                        resolve({
                            'message': 'User Logged Out'
                        });
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        },
        resetToDefault ({ commit }, payload) {
            return new Promise((resolve, reject) => {
                axios.post(`/api/auth/resetToDefault/${payload.id}`)
                    .then((response) => {
                        resolve({
                            'message': 'Password Resetted!'
                        })
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        },
        resetPassword ({ commit }, payload) {
            return new Promise((resolve, reject) => {
                axios.post(`/api/auth/resetPassword`, payload, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('access_token')}`
                    }
                })
                    .then((response) => {
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        }
    }
}

export default auth;