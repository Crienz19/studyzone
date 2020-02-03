<template>
    <v-app class="back-image">
        <v-app-bar app color="transparent" elevation="0">
            <v-spacer></v-spacer>
            <v-btn @click="logout" text>logout</v-btn>
        </v-app-bar>
        <v-content>
            <v-container fill-height fluid>
                <router-view></router-view>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    export default {
        methods: {
            logout () {
                if (this.$store.getters['auth/isAuthenticated']) {
                    this.$store.dispatch('auth/logout')
                        .then(async (response) => {
                            await this.$router.push('/auth/login');
                        })
                        .catch(error => {
                            this.$swal.fire({
                                type: 'error',
                                title: 'Something wen\'t wrong.'
                            })
                        })
                    
                } else {
                    this.$router.push('/auth/login');
                }
            }
        }
    }
</script>

<style scoped>
    .back-image {
        background-image: url('../../assets/images/16414.jpg');
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
    }
</style>