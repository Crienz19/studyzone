<template>
    <v-row dense>
        <v-col cols="12">
            <v-alert type="info" :value="true">
                <strong>Info!</strong>
            </v-alert>
        </v-col>
        <v-col cols="12">
            <v-card>
                <v-card-title>
                    Amenities
                    <v-spacer></v-spacer>
                    <add-amenities-modal />
                </v-card-title>
                <v-data-table
                    :headers="headers"
                    :items="amenities"
                    disable-sort
                >
                    <template v-slot:item.actions="{ item }">
                        <v-btn @click="deleteAmenities(item)" color="error" small>delete</v-btn>
                    </template>
                </v-data-table>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    import AddAmenitiesModal from '@/components/admin/amenities/AddAmenitiesModal.vue';

    export default {
        components: {
            AddAmenitiesModal
        },
        layout: 'admin',
        data () {
            return {
                headers: [
                    { text: 'Name', align: 'left', value: 'name' },
                    { text: 'Price', align: 'center', value: 'price' },
                    { text: 'Actions', align: 'center', value: 'actions' }
                ]
            }
        },
        computed: {
            amenities () {
                return this.$store.getters['amenities/GET_ALL_AMENITIES'];
            }
        },
        async mounted() {
            await this.$store.dispatch('amenities/loadAmenities');
        },
        methods: {
            async deleteAmenities (amenities) {
                this.$swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.value) {
                            this.$store.dispatch('amenities/deleteAmenities', amenities)
                                .then(async (response) => {
                                    await this.$store.dispatch('amenities/loadAmenities');
                                    await this.$swal.fire(
                                        'Deleted!',
                                        'Amenities has been deleted.',
                                        'success'
                                    )
                                })
                                .catch(error => {
                                    alert('Error');
                                })
                        }
                    });
            }
        }
    }
</script>