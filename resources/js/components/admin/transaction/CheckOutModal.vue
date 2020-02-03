<template>
    <v-dialog v-model="discountDialog" persistent max-width="350px">
        <template v-slot:activator="{ on }">
            <v-btn small color="error" v-on="on">Clock Out</v-btn>
        </template>
        <v-card>
            <v-card-title>
                <h3>Discount?</h3>
                <v-spacer></v-spacer>
                <v-btn icon @click="discountDialog = false">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-container>
                <v-row dense>
                    <v-col cols="12">
                        <v-text-field
                            label="Discount"
                            v-model="form.discount"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-btn @click="clockOutNow()" color="error" block>Clock Out Now</v-btn>
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
                discountDialog: false,
                form: {
                    discount: this.transaction.discount
                }
            }
        },
        methods: {
            async clockOutNow () {
                await this.$axios.post(`/api/admin/clockOut/${this.transaction.id}`, this.form)
                    .then((response) => {
                        this.discountDialog = false;
                        this.$store.dispatch('transaction/loadTransaction')
                    })
                    .catch(error => {
                        console.log(error);
                    })
            }
        }
    }
</script>