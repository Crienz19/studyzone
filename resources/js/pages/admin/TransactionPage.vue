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
            <v-alert
                v-for="notif in notifications"
                :key="notif.id"
                dense
                type="info"
                dismissible
            >
                {{ notif.user.name }} is has ended his/her session.
            </v-alert>

            <v-card :loading="loading" :disabled="loading">
                <v-card-title>
                    <h3>Transactions</h3>
                    <v-spacer></v-spacer>
                    <v-text-field
                        label="Search"
                        v-model="search"
                    ></v-text-field>
                </v-card-title>
                <v-data-table
                    :headers="headers"
                    :items="transactions"
                    :search="search"
                    disable-sort
                >
                    <template v-slot:item.duration="{ item }">
                        <div>{{ item.duration }} hrs.</div>
                    </template>
                    <template v-slot:item.discount="{ item }">
                        <i>{{ item.discount }}%</i>
                    </template>
                    <template v-slot:item.actions="{ item }">
                        <check-out-modal v-if="item.status == 'CLOCKED IN'" :transaction="item" />
                        <add-time-modal v-if="item.status == 'CLOCKED IN'" :transaction="item" />
                        <div v-if="item.status == 'CLOCKED OUT'">
                            <label>Not Applicable</label>
                        </div>
                    </template>
                    <template v-slot:item.status="{ item }">
                        <v-chip small color="green" v-if="item.status == 'CLOCKED IN'">{{ item.status }}</v-chip>
                        <v-chip small color="red" v-if="item.status == 'CLOCKED OUT'">{{ item.status }}</v-chip>
                    </template>
                </v-data-table>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    import CheckOutModal from '@/components/admin/transaction/CheckOutModal.vue';
    import AddTimeModal from '@/components/admin/transaction/AddTimeModal.vue';
    export default {
        components: {
            CheckOutModal,
            AddTimeModal
        },
        layout: 'admin',
        data () {
            return {
                headers: [
                    { text: 'Type', align: 'center', value: 'type'},
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
                    { text: 'Actions', align: 'center', value: 'actions' }
                ],
                datas: [],
                notifications: [],
                discountDialog: false,
                form: {
                    discount: ''
                },
                search: '',
                loading: false
            }
        },
        computed: {
            transactions () {
                return this.$store.getters['transaction/GET_TRANSACTIONS'];
            }
        },
        async mounted () {
            this.loading = true;
            await this.$store.dispatch('transaction/loadTransaction');
            this.loading = false;
        }
    }
</script>