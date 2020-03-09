<template>
    <v-row>
        <v-col cols="4">
            <v-card color="blue" class="pa-5">
                <v-list-item>
                    <v-list-item-avatar size="75px" color="black">
                        <v-icon size="50">mdi-cash-100</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title class="headline">{{ $store.getters['service/GET_TOTAL_REVENUE'] }}</v-list-item-title>
                        <v-list-item-subtitle>Total Revenue As Of Today</v-list-item-subtitle>
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
                        <v-list-item-title class="headline">{{ $store.getters['service/GET_TOTAL_ITEMS_SOLD'] }}</v-list-item-title>
                        <v-list-item-subtitle>Total Item Sold As of Today</v-list-item-subtitle>
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
                        <v-list-item-title class="headline">{{ $store.getters['service/GET_TOTAL_TRANSACTIONS'] }}</v-list-item-title>
                        <v-list-item-subtitle>Total Transaction Tendered As Of Today</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-card>
        </v-col>
        <v-col cols="12">
            <v-card :loading="loading" :disabled="loading">
                <v-card-title>
                    Overall Services
                    <v-spacer></v-spacer>
                    <download-excel
                        :data="services"
                        :fields="fields"
                    >Download</download-excel>
                </v-card-title>
                <v-data-table
                    :headers="headers"
                    :items="services"
                    disable-sort
                >                    
                </v-data-table>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        layout: 'admin',
        data () {
            return {
                headers: [
                    { text: 'Service', align: 'left', value: 'amenities.name' },
                    { text: 'Price', align: 'center', value: 'amenities.price' },
                    { text: 'Quantity', align: 'center', value: 'quantity' },
                    { text: 'Total', align: 'center', value: 'total' },
                    { text: 'Date Transacted', align: 'center', value: 'created_at' },
                ],
                fields: {
                    'Service': 'amenities.name',
                    'Price': 'amenities.price',
                    'Quantity': 'quantity', 
                    'Total': 'total',
                    'Date Transacted': 'created_at'
                },
                loading: false
            }
        },
        computed: {
            services () {
                return this.$store.getters['service/GET_ALL_SERVICE'];
            }
        },
        async mounted() {
            this.loading = true;
            await this.$store.dispatch('service/loadOverallServices');
            this.loading = false;
        },
    }
</script>

<style>

</style>