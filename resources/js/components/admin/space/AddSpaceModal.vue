<template>
    <v-dialog v-model="addDialog" persistent max-width="350px">
        <template v-slot:activator="{ on }">
            <v-btn color="primary" small v-on="on">add space</v-btn>
        </template>
        <v-card>
            <v-card-title>
                <h4>Add Space</h4>
                <v-spacer></v-spacer>
                <v-btn icon @click="addDialog = false">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-container>
                <v-form>
                    <v-row dense>
                        <v-col cols="12">
                            <v-text-field
                                label="Name"
                                v-model="form.name"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                label="Description"
                                v-model="form.description"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                label="Rate"
                                v-model="form.rate"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                label="Daily"
                                v-model="form.daily_rate"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                label="Weekly Rate"
                                v-model="form.weekly_rate"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                label="Montly Rate"
                                v-model="form.monthly_rate"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                label="Capacity"
                                type="number"
                                v-model.number="form.capacity"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-btn @click="addSpace" block color="primary">Add</v-btn>
                        </v-col>
                    </v-row>
                </v-form>
            </v-container>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        data () {
            return {
                addDialog: false,
                form: {
                    name: '',
                    description: '',
                    rate: 0,
                    daily_rate: 0,
                    weekly_rate: 0,
                    monthly_rate: 0,
                    capacity: 0
                }
            }
        },
        methods: {
            async addSpace () {
                await this.$store.dispatch('space/addSpace', this.form)
                    .then((response) => {
                        this.addDialog = false;
                        this.$store.dispatch('space/loadSpaces');
                        this.$swal.fire({
                            type: 'success',
                            title: 'Space added successfully.'
                        });
                    })
                    .catch(error => {
                        this.$swal.fire({
                            type: 'error',
                            title: 'Something went wrong.'
                        })
                    }) 
            }
        }
    }
</script>