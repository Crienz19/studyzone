<template>
    <v-row dense justify="center" align="center">
        <v-col cols="12">
            <v-alert type="info" :value="true">
                <strong>Info!</strong>
            </v-alert>
        </v-col>
        <v-col cols="12">
            <v-card>
                <v-card-title>
                    Space List
                    <v-spacer></v-spacer>
                    <add-space-modal />
                </v-card-title>
                <v-data-table
                    :headers="headers"
                    :items="spaces"
                    disable-sort
                >
                    <template v-slot:item.status="{ item }">
                        <v-icon color="green" v-if="item.status">mdi-check</v-icon>
                        <v-icon color="red" v-else>mdi-close</v-icon>
                    </template>
                    <template v-slot:item.actions="{ item }">
                        <edit-space-modal :space="item" />
                        <v-btn @click="deleteSpace(item)" color="error" small>delete</v-btn>
                    </template>
                </v-data-table>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    import AddSpaceModal from '@/components/admin/space/AddSpaceModal.vue';
    import EditSpaceModal from '@/components/admin/space/EditSpaceModal.vue';
    export default {
        layout: 'admin',
        components: {
            AddSpaceModal,
            EditSpaceModal
        },
        data () {
            return {
                headers: [
                    { text: 'Name', align: 'left', value: 'name' },
                    { text: 'Description', align: 'center', value: 'description' },
                    { text: 'Hourly Rate (PHP)', align: 'center', value: 'rate'},
                    { text: 'Daily Rate (PHP)', align: 'center', value: 'daily_rate'},
                    { text: 'Weekly Rate (PHP)', align: 'center', value: 'weekly_rate' },
                    { text: 'Monthy Rate (PHP)', align: 'center', value: 'monthly_rate' },
                    { text: 'Capacity', align: 'center', value: 'capacity' },
                    { text: 'Actions', align: 'center', value: 'actions' }
                ],
                form: {
                    name: '',
                    description: '',
                    rate: 0,
                    daily_rate: 0,
                    weekly_rate: 0,
                    monthly_rate: 0
                }
            }
        },
        computed: {
            spaces () {
                return this.$store.getters['space/GET_ALL_SPACES'];
            }
        },
        async mounted () {
            await this.$store.dispatch('space/loadSpaces');
        },
        methods: {
            async deleteSpace (item) {
                await this.$swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.value) {
                            this.$store.dispatch('space/deleteSpace', item)
                                .then((response) => {
                                    this.$store.dispatch('space/loadSpaces');
                                    this.$swal.fire({
                                        type: 'success',
                                        title: 'Space Deleted!'
                                    })
                                })
                                .catch(error => {
                                    this.$swal.fire({
                                        type: 'error',
                                        title: 'Something went wrong.'
                                    })
                                })
                    }
                })
            }
        }
    }
</script>