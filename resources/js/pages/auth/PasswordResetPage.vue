<template>
    <v-row justify="center" align-content="center">
        <v-col cols="12" sm="12" md="5" lg="3">
            <v-card class="login-box-transparent" :loading="loading" :disabled="loading">
                <v-card-title>
                    <h3>Password Reset</h3>
                </v-card-title>
                <v-container class="pa-5">
                    <v-form>
                        <v-row dense>
                            <v-col cols="12">
                                <v-text-field
                                    label="Current Password"
                                    type="password"
                                    prepend-icon="mdi-lock"
                                    dense
                                    v-model="form.current"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    label="New Password"
                                    type="password"
                                    prepend-icon="mdi-lock"
                                    dense
                                    v-model="form.new"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-btn color="info" block @click="resetPassword">Password Reset</v-btn>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-container>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        layout: 'client',
        data () {
            return {
                loading: false,
                form: {
                    current: '',
                    new: ''
                }
            }
        },
        methods: {
            async resetPassword () {
                await this.$store.dispatch('auth/resetPassword', this.form)
                    .then(async (response) => {
                        await this.$store.dispatch('auth/logout')
                            .then(async (response) => {
                                await this.$swal.fire({
                                    type: 'success',
                                    title: 'Password Reset',
                                    text: 'Logging You Out'
                                });
                                await this.$router.push('/auth/login');
                            })
                            .catch(error => {
                                this.$swal.fire({
                                    type: 'error',
                                    title: 'Something wen\'t wrong.'
                                })
                            })
                    })
                    .catch(error => {
                        console.log(error.response.data.message);
                        this.$swal.fire({
                            type: 'error',
                            title: error.response.data.message
                        })
                    })
            }
        }
    }
</script>

<style scoped>
    .login-box-transparent {
        background-color: rgba(0, 0, 0, 0.5);
        border: 2px solid white;
    }
</style>