<template>
    <v-dialog v-model="editDialog" persistent max-width="350px">
        <template v-slot:activator="{ on }">
            <v-btn color="success" small v-on="on">edit</v-btn>
        </template>
        <v-card>
            <v-card-title>
                <h4>Edit Space</h4>
                <v-spacer></v-spacer>
                <v-btn icon @click="editDialog = false">
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
                                label="Daily Rate"
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
                            <v-btn @click="updateSpace" block color="primary">Update</v-btn>
                        </v-col>
                    </v-row>
                </v-form>
            </v-container>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        props: [
            'space'
        ],
        data () {
            return {
                editDialog: false,
                form: {
                    id: this.space.id,
                    name: this.space.name,
                    description: this.space.description,
                    rate: this.space.rate,
                    daily_rate: this.space.daily_rate,
                    weekly_rate: this.space.weekly_rate,
                    monthly_rate: this.space.monthly_rate,
                    capacity: this.space.capacity
                }
            }
        },
        methods: {
            async updateSpace () {
                await this.$store.dispatch('space/updateSpace', this.form)
                    .then(async (response) => {
                        await this.$store.dispatch('space/loadSpaces');
                        await this.$swal.fire({
                            type: 'success',
                            title: 'Space added successfully.'
                        });
                        this.editDialog = false;
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