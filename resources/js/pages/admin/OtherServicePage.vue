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
                    Other Service
                    <v-spacer></v-spacer>
                    <add-service-modal />
                </v-card-title>
                <v-data-table
                    :headers="headers"
                    :items="services"
                    disable-sort
                >
                    <template v-slot:item.actions="{ item }">
                        <v-btn color="error" small>delete</v-btn>
                    </template>
                </v-data-table>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    import AddServiceModal from '@/components/admin/service/AddServiceModal.vue';
    export default {
        components: {
            AddServiceModal
        },
        layout: 'admin',
        data () {
            return {
                headers: [
                    { text: 'Service', align: 'left', value: 'amenities.name' },
                    { text: 'Price', align: 'center', value: 'amenities.price' },
                    { text: 'Quantity', align: 'center', value: 'quantity' },
                    { text: 'Total', align: 'center', value: 'total' },
                    { text: 'Date Transacted', align: 'center', value: 'created_at' },
                    { text: 'Actions', align: 'center', value: 'actions' }
                ],
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
            await this.$store.dispatch('service/loadServices')
                .then((response) => {
                    console.log(response);
                    this.loading = false;
                })
        },
    }
</script>