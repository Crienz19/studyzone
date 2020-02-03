<template>
    <v-row justify="center" align="center">
        <v-col cols="3">
            <v-card dark :loading="loading" :disabled="loading">
                <v-card-title  class="text-xs-center">
                    <h1>STUDY ZONE</h1>
                </v-card-title>
                <v-container class="pa-5">
                    <v-form>
                        <v-row dense>
                            <v-col cols="12">
                                <v-text-field
                                    label="Passcode"
                                    type="password"
                                    dense
                                    v-model.trim="form.passcode"
                                    outlined
                                    append-icon="mdi-send"
                                    @click:append="logMeIn"
                                ></v-text-field>
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
                    passcode: ''
                }
            }
        },
        methods: {
            logMeIn () {
                if (this.form.passcode == '123456') {
                    localStorage.setItem('access', true);
                    this.$router.push('/admin/dashboard');
                } else {
                    alert('Passcode Incorrect!');
                }
            }
        }
    }
</script>