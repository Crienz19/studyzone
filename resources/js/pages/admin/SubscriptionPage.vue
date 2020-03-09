<template>
    <v-row justify="center" align="center">
        <v-col cols="4">
            <v-card color="blue" class="pa-5">
                <v-list-item>
                    <v-list-item-avatar size="75px" color="black">
                        <v-icon size="50">mdi-cash-100</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title class="headline">{{ $store.getters['subscription/GET_TOTAL_NO_OF_SUBSCRIPTIONS'] }}</v-list-item-title>
                        <v-list-item-subtitle>Total Number of Subscriptions</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-card>
        </v-col>
        <v-col cols="4">
            <v-card color="blue" class="pa-5">
                <v-list-item>
                    <v-list-item-avatar size="75px" color="black">
                        <v-icon size="50">mdi-card-text-outline</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title class="headline">{{ $store.getters['subscription/GET_TOTAL_REVENUE'] }}</v-list-item-title>
                        <v-list-item-subtitle>Total Number of Sold Cards</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-card>
        </v-col>
        <v-col cols="4">
            <v-card color="blue" class="pa-5">
                <v-list-item>
                    <v-list-item-avatar size="75px" color="black">
                        <v-icon size="50">mdi-cash-100</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title class="headline">{{ $store.getters['subscription/GET_TOTAL_ACTIVE_SUBSCRIPTIONS'] }}</v-list-item-title>
                        <v-list-item-subtitle>Total Number of Sold Cards</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-card>
        </v-col>
        <v-col cols="12">
            <v-card :loading="loading" :disabled="loading">
                <v-card-title>
                    <h3>Subscription</h3>
                    <v-spacer></v-spacer>
                    <v-btn icon @click="$store.dispatch('subscription/loadSubscriptions')">
                        <v-icon>mdi-refresh</v-icon>
                    </v-btn>
                </v-card-title>
                <v-data-table
                    :headers="headers"
                    :items="subscriptions"
                    disable-sort
                >
                    <template v-slot:item.status="{ item }">
                        <v-chip v-if="item.status" color="green" small>Active</v-chip>
                        <v-chip v-else color="error" small>Inactive</v-chip>
                    </template>
                </v-data-table>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    import AddSubscriptionModal from '@/components/admin/subscription/AddSubscriptionModal.vue';
    export default {
        layout: 'admin',
        components: {
            AddSubscriptionModal
        },
        data () {
            return {
                headers: [
                    { text: 'Code', align: 'left', value: 'subscription_code' },
                    { text: 'Space', align: 'center', value: 'space.name' },
                    { text: 'Plan', align: 'center', value: 'plan'},
                    { text: 'Client', align: 'center', value: 'user.name' },
                    { text: 'Date Registered', align: 'center', value: 'date_registered'  },
                    { text: 'Date Expired', align: 'center', value: 'date_expired' },
                    { text: 'Price', align: 'center', value: 'price' },
                    { text: 'Status', align: 'center', value: 'status' },
                ],
                loading: false
            }
        },
        computed: {
            subscriptions () {
                return this.$store.getters['subscription/GET_SUBSCRIPTIONS']
            }
        },
        async mounted() {
            this.loading = true;
            await this.$store.dispatch('subscription/loadSubscriptions')
            this.loading = false;
        },
    }
</script>