<template>
    <v-dialog v-model="subscriptionModal" persistent max-width="450px">
        <template v-slot:activator="{ on }">
            <v-btn color="primary" small v-on="on">add subscription</v-btn>
        </template>
        <v-card>
            <v-card-title>
                <h3>New Subscription</h3>
                <v-spacer></v-spacer>
                <v-btn @click="subscriptionModal = false" icon>
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-container>
                <v-row dense>
                    <v-col cols="12">
                        <v-text-field
                            v-model="form.subscription_code"
                            label="Subscription Code"
                            placeholder="Subscription code"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                        <v-select
                            :items="space"
                            v-model="form.subscription_space"
                            item-text="name"
                            item-value="id"
                            label="Subscription Space"
                            placeholder="Subscription space"
                        ></v-select>
                    </v-col>
                    <v-col cols="12">
                        <v-select
                            :items="[
                                { name: 'WSP', display_name: 'Week Subscription Plan' },
                                { name: 'MSP', display_name: 'Month Subscription Plan' }
                            ]"
                            v-model="form.subscription_plan"
                            item-text="display_name"
                            item-value="name"
                            label="Subscription Plan"
                            placeholder="Subscription plan"
                        ></v-select>
                    </v-col>
                    <v-col cols="12">
                        <v-btn @click="addSubscription" color="success" block>Add</v-btn>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        props: [
            'user'
        ],
        data () {
            return {
                form: {
                    subscription_code: '',
                    subscription_space: '',
                    subscription_plan: '',
                    client: '',
                    date_registered: '',
                    date_expired: '',
                },
                space: [],
                subscriptionModal: false
            }
        },
        async mounted() {
            await this.$axios.get('/api/space/getAll')
                .then((response) => {
                    this.space = response;
                });
        },
        methods: {
            async addSubscription () {
                await this.$axios.post(`/api/subscription/addSubscription/${this.user.id}`, this.form)
                    .then((response) => {
                        alert(response.message);
                    })
            }
        }
    }
</script>