<template>
    <v-dialog v-model="addTimeDialog" persistent max-width="350px">
        <template v-slot:activator="{ on }">
            <v-btn color="info" v-on="on" small>Add Time</v-btn>
        </template>
        <v-card>
            <v-card-title>
                <h3>Add Time</h3>
                <v-spacer></v-spacer>
                <v-btn icon @click="addTimeDialog = false;">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-container>
                <v-row dense>
                    <v-col cols="12">
                        <v-text-field
                            label="Number of Hours"
                            type="number"
                            v-model="form.hours"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-btn @click="extend" block color="success">extend</v-btn>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        props: [
            'transaction'
        ],
        data () {
            return {
                addTimeDialog: false,
                form: {
                    hours: 0
                }
            }
        },
        methods: {
            async extend () {
                await this.$axios.post(`/api/admin/addTime/${this.transaction.id}`, this.form)
                    .then((response) => {
                        this.addTimeDialog = false;
                        this.$store.dispatch('transaction/loadTransaction')
                    })
            }
        }
    }
</script>