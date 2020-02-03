<template>
    <v-row dense>
        <v-col cols="12">
            <v-alert type="primary" :value="true">
                <strong>Info</strong>
            </v-alert>
            <!-- <v-card color="blue" class="pa-5">
                <v-list-item>
                    <v-list-item-avatar size="75px" color="grey"></v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title class="headline">Our Changing Planet</v-list-item-title>
                        <v-list-item-subtitle>by Kurt Wagner</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-card> -->
        </v-col>
        <v-col cols="12">
            <v-card>
                <v-card-title>
                    <h3>Clients</h3>
                    <v-spacer></v-spacer>
                    <v-text-field
                        label="Search"
                        v-model="search"
                    ></v-text-field>
                    <download-excel
                        class="ml-2"
                        :data="users"
                        :fields="fields"
                    >Export</download-excel>
                </v-card-title>
                <v-data-table
                    :headers="headers"
                    :items="users"
                    :search="search"
                >
                    <template v-slot:item.actions="{ item }">
                        <add-subscription-modal :user="item" />
                        <v-btn @click="resetToDefault(item)" color="success" small>Reset Password</v-btn>
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
                    { text: 'User ID', align: 'left', value: 'id' },
                    { text: 'Full name', align: 'center', value: 'name' },
                    { text: 'Email', align: 'center', value: 'email' },
                    { text: 'Organization', align: 'center', value: 'organization' },
                    { text: 'Contact No.', align: 'center', value: 'contact_no' },
                    { text: 'Actions', align: 'center', value: 'actions' }
                ],
                fields: {
                    'User ID': 'id',
                    'Fullname': 'name',
                    'Email': 'email',
                    'Organization': 'organization',
                    'Contact Number': 'contact_no'
                },
                users: [],
                search: ''
            }
        },
        async mounted() {
            await this.$axios.get('/api/user/getAllUsers')
                .then((response) => {
                    this.users = response.data;
                })
        },
        methods: {
            async resetToDefault (item) {
                await this.$store.dispatch('auth/resetToDefault', item)
                    .then((response) => {
                        this.$swal.fire({
                            type: 'success',
                            title: 'Password Resetted.'
                        })
                    })
            }
        }
    }
</script>