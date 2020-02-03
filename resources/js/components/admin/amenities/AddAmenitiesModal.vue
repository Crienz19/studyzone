<template>
    <v-dialog v-model="amenitiesDialog" persistent max-width="450px">
        <template v-slot:activator="{ on }">
            <v-btn color="primary" small v-on="on">add amenities</v-btn>
        </template>
        <v-card>
            <v-card-title>
                Create Amenities
                <v-spacer></v-spacer>
                <v-btn icon @click="amenitiesDialog = false">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-container>
                <v-row dense>
                    <v-col cols="12">
                        <v-text-field
                            label="Name"
                            v-model="form.name"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field
                            label="Price"
                            v-model="form.price"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-btn block color="primary" @click="addAmenities">Add</v-btn>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        data () {
            return {
                amenitiesDialog: false,
                form: {
                    name: '',
                    price: ''
                }
            }
        },
        methods: {
            async addAmenities () {
                await this.$store.dispatch('amenities/insertAmenities', this.form)
                    .then(async (response) => {
                        await this.$store.dispatch('amenities/loadAmenities');
                        await this.$swal.fire({
                            type: 'success',
                            title: 'Amenities Added.'
                        })
                        this.amenitiesDialog = false;
                    })
                    .catch(error => {
                        alert('error');
                    })
            }
        }
    }
</script>