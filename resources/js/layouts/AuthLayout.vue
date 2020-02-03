<template>
    <v-app app class="back-image">
        <v-content app>
            <v-container fill-height>
                <router-view></router-view>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    export default {
        
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