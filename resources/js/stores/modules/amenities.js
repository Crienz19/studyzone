import axios from 'axios';

const amenities = {
    namespaced: true,
    state: {
        amenities: []
    },
    getters: {
        GET_ALL_AMENITIES (state) {
            return state.amenities;
        }
    },
    mutations: {
        SET_AMENITIES (state, payload) {
            state.amenities = payload;
        }
    },
    actions: {
        loadAmenities ({ commit }) {
            return new Promise((resolve, reject) => {
                axios.get('/api/amenities/getAllAmenities')
                    .then((response) => {
                        commit('SET_AMENITIES', response.data);
                        resolve({
                            'message': 'Amenities Loaded.'
                        });
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        },
        insertAmenities ({ dispatch }, amenity) {
            return new Promise((resolve, reject) => {
                axios.post('/api/amenities/storeAmenities', amenity)
                    .then((response) => {
                        resolve({
                            'message': 'Amenities Added'
                        });
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
        updateAmenities ({ dispatch }, amenity) {
            return new Promise((resolve, reject) => {

            })
        },
        deleteAmenities ({ dispatch }, amenity) {
            return new Promise((resolve, reject) => {
                axios.delete(`/api/amenities/deleteAmenities/${amenity.id}`)
                    .then((response) => {
                        resolve({
                            'message': 'Amenities deleted'
                        })
                    })
                    .catch(error => {
                        reject(error);
                    })
            })
        }
    }
}

export default amenities;