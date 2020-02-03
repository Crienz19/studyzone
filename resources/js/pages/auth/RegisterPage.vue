<template>
    <v-row justify="center" align-content="center">
        <v-col cols="12" md="5" lg="3">
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
                                    v-model.trim="form.name"
                                    label="Full Name"
                                    type="text"
                                    prepend-icon="mdi-pencil"
                                    dense
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="form.organization"
                                    label="School/Company/Organization"
                                    type="text"
                                    prepend-icon="mdi-school"
                                    dense
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    v-model.trim="form.contact_no"
                                    label="Contact No."
                                    type="text"
                                    prepend-icon="mdi-phone"
                                    dense
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    v-model.trim="form.email"
                                    label="Email"
                                    type="email"
                                    prepend-icon="mdi-mail"
                                    dense
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    v-model.trim="form.password"
                                    label="Password"
                                    type="password"
                                    prepend-icon="mdi-lock"
                                    dense
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-btn @click="register" color="info" block>create account</v-btn>
                            </v-col>
                            <v-col cols="12">
                                <v-btn to="/auth/login" color="error" block>I already have an account</v-btn>
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
                form: {
                    name: '',
                    organization: '',
                    contact_no: '',
                    email: '',
                    password: ''
                },
                errors: [],
                loading: false
            }
        },
        methods: {
            register () {
                this.loading = true;
                this.$axios.post('/api/auth/register', this.form)
                    .then((response) => {
                        this.loading = false;
                        this.$router.push('/auth/login');
                        this.$swal.fire({
                            type: 'success',
                            title: 'Details successfully registered',
                            text: 'Redirecting to Login Page'
                        })
                    })
                    .catch(error => {
                        this.loading = false;
                        this.errors = [];
                        this.errors.push(error.response.data.errors);
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