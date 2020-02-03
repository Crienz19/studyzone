<template>
    <v-dialog v-model="serviceModal" persistent max-width="450px">
        <template v-slot:activator="{ on }">
            <v-btn color="primary" small v-on="on">add service</v-btn>
        </template>
        <v-card>
            <v-card-title>
                Add Transaction
                <v-spacer></v-spacer>
                <v-btn icon @click="serviceModal = false">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-container>
                <v-row dense>
                    <v-col cols="12">
                        <v-select
                            label="Select Service"
                            :items="amenities"
                            item-text="name"
                            item-value="id"
                            v-model="form.amenities"
                        ></v-select>
                    </v-col>
                    <v-col cols="12">
                        <v-text-field
                            label="Quantity"
                            type="number"
                            v-model.number="form.quantity"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-btn block color="primary" @click="addTransaction">Add Transaction</v-btn>
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
                serviceModal: false,
                amenities: [],
                form: {
                    amenities: '',
                    quantity: 0
                }
            }
        },
        async mounted() {
            await this.$axios.get('/api/amenities/getAllAmenities')
                .then((response) => {
                    this.amenities = response.data;
                })
        },
        methods: {
            async addTransaction () {
                await this.$store.dispatch('service/addService', this.form)
                    .then((response) => {
                        this.$store.dispatch('service/loadServices');
                        this.$swal('Test');
                        this.serviceModal = false;
                    })
                    .catch(error => {
                        alert('error')
                    })
            }
        }
    }
</script>

<style>

</style>