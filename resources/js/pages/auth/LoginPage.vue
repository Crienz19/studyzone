<template>
    <v-row justify="center" align-content="center">
        <v-col cols="12" sm="12" md="5" lg="3">
            <v-card class="login-box-transparent" :loading="loading" :disabled="loading">
                <v-card-title class="justify-center align-center">  
                    <p class="mt-7 mb-0 pa-0" style="font-size: 20px;">Hospitality Institute of America Philippines, Inc.</p>
                    <p>Study Zone</p>
                </v-card-title>
                <v-container class="pa-5">
                    <v-form>
                        <v-row dense>
                            <v-col cols="12">
                                <v-text-field
                                    label="Email"
                                    type="email"
                                    prepend-icon="mdi-mail"
                                    dense
                                    v-model="form.email"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    label="Password"
                                    type="password"
                                    prepend-icon="mdi-lock"
                                    dense
                                    v-model="form.password"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" class="mt-5">
                                <v-btn color="info" block @click="clockIn">Login</v-btn>
                            </v-col>
                            <v-col cols="12">
                                <v-btn to="/auth/register" color="error" block>I dont have an account</v-btn>
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
        layout: 'auth',
        data () {
            return {
                loading: false,
                form: {
                    email: '',
                    password: ''
                }
            }
        },
        methods: {
            async clockIn () {
                this.loading = true;
                await this.$store.dispatch('auth/login', this.form)
                    .then(async (response) => {
                        this.loading = false;
                        console.log(response.data.data);
                        await this.$swal.fire({
                            type: 'success',
                            title: 'Successfully Logged In.'
                        })
                        if (response.data.data.password_is_default == 0) {
                            await this.$router.push('/client/dashboard');
                        } else {
                            await this.$router.push('/auth/password-reset')
                        }
                    })
                    .catch(error => {
                        this.loading = false;
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