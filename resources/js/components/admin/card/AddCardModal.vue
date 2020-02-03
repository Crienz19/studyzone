<template>
    <v-dialog v-model="cardDialog" persistent max-width="350px">
        <template v-slot:activator="{ on }">
            <v-btn small color="primary" v-on="on">Add Card</v-btn>
        </template>

        <v-card>
            <v-card-title>
                <h3>Card Register</h3>
                <v-spacer></v-spacer>
                <v-btn icon @click="cardDialog = false">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-container>
                <v-row dense>
                    <v-col cols="12">
                        <v-text-field
                            label="Control #"
                            placeholder="123456789000000"
                            v-model="form.control_no"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-select
                            label="Type of Card"
                            :items="[
                                { name: 'DC', display_name: 'Discount Card' },
                                { name: 'AAC', display_name: 'All Access Card' },
                            ]"
                            item-text="display_name"
                            item-value="name"
                            v-model="form.type"
                        ></v-select>
                    </v-col>
                    <v-col cols="12">
                        <v-btn @click="registerCard" color="success" block>Register Card</v-btn>
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
                cardDialog: false,
                form: {
                    control_no: '',
                    type: ''
                }
            }
        },
        methods: {
            async registerCard () {
                await this.$store.dispatch('card/addCard', this.form)
                    .then(async (response) => {
                        await this.$store.dispatch('card/loadCards')
                        await this.$swal.fire({
                            type: 'success',
                            title: 'Card Added.'
                        });
                        this.cardDialog = false;
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