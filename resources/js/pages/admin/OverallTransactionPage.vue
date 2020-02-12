<template>
    <v-row>
        <v-col cols="4">
            <v-card color="blue" class="pa-5">
                <v-list-item>
                    <v-list-item-avatar size="75px" color="black">
                        <v-icon size="50">mdi-cash-100</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title class="headline">{{ $store.getters['transaction/GET_TOTAL_PROFIT'] }}</v-list-item-title>
                        <v-list-item-subtitle>Total Profit As Of Today</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-card>
        </v-col>
        <v-col cols="4">
            <v-card color="blue" class="pa-5">
                <v-list-item>
                    <v-list-item-avatar size="75px" color="black">
                        <v-icon size="50">mdi-account-group</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title class="headline">{{ $store.getters['transaction/GET_TOTAL_PAX'] }}</v-list-item-title>
                        <v-list-item-subtitle>Total Visitors As Of Today</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-card>
        </v-col>
        <v-col cols="4">
            <v-card color="blue" class="pa-5">
                <v-list-item>
                    <v-list-item-avatar size="75px" color="black">
                        <v-icon size="50">mdi-login-variant</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title class="headline">{{ $store.getters['transaction/GET_TOTAL_LOGGED_CLIENT'] }}</v-list-item-title>
                        <v-list-item-subtitle>Logged Users Total</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-card>
        </v-col>
        <v-col cols="12">
            <v-card>
                <v-card-title>
                    Overall Transactions
                    <v-spacer></v-spacer>
                    <download-excel
                        :data="transactions"
                        :fields="fields"
                    >
                        Download
                    </download-excel>
                </v-card-title>
                <v-data-table
                    :headers="headers"
                    :items="transactions"
                    disable-sort
                >
                    <template v-slot:item.status="{ item }">
                        <v-chip small color="green" v-if="item.status == 'CLOCKED IN'">{{ item.status }}</v-chip>
                        <v-chip small color="red" v-if="item.status == 'CLOCKED OUT'">{{ item.status }}</v-chip>
                    </template>
                    <template v-slot:item.actions="{ item }">
                        <check-out-modal v-if="item.status == 'CLOCKED IN'" :transaction="item" />
                        <v-btn small color="error" @click="deleteTransaction(item.id)">delete</v-btn>
                    </template>
                </v-data-table>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    import CheckOutModal from '@/components/admin/overall/CheckOutModal.vue';
    export default {
        layout: 'admin',
        components: {
            CheckOutModal
        },
        data () {
            return {
                headers: [
                    { text: 'Type', align: 'left', value: 'type'},
                    { text: 'Name', align: 'center', value: 'user.name'},
                    { text: 'Space', align: 'center', value: 'space.name' },
                    { text: 'Rate', align: 'center', value: 'space.rate' },
                    { text: 'Pager', align: 'center', value: 'pager_no' },
                    { text: 'Start', align: 'center', value: 'start' },
                    { text: 'End', align: 'center', value: 'end' },
                    { text: 'Duration (hrs)', align: 'center', value: 'duration' },
                    { text: 'Pax', align: 'center', value: 'pax' },
                    { text: 'Sub-total', align: 'center', value: 'sub_total'},
                    { text: 'Discount (%)', align: 'center', value: 'discount'},
                    { text: 'Total', align: 'center', value: 'total' },
                    { text: 'Status', align: 'center', value: 'status'},
                    { text: 'Date Transacted', align: 'center', value: 'created_at' },
                    { text: 'Actions', align: 'center', value: 'actions' }
                ],
                fields: {
                    'Type': 'type',
                    'Name': 'user.name',
                    'Space': 'space.name',
                    'Rate': 'space.rate',
                    'Pager': 'pager_no',
                    'Start': 'start',
                    'End': 'end',
                    'Duration': 'duration',
                    'Pax': 'pax',
                    'Sub Total': 'sub_total',
                    'Discount': 'discount',
                    'Total': 'total',
                    'Status': 'status',
                    'Date Transacted': 'created_at'
                }
            }
        },
        computed: {
            transactions () {
                return this.$store.getters['transaction/GET_TRANSACTIONS']
            }
        },
        async mounted() {
            await this.$store.dispatch('transaction/loadOverallTransaction');
        },
        methods: {
            async deleteTransaction (id) {
                await this.$store.dispatch('transaction/deleteTransaction', id);
            }
        }
    }
</script>