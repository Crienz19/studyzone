<template>
    <v-row justify="center" align="center">
        <v-col cols="12" md="5" lg="6" v-if="step == 1">
            <v-container>
                <v-row>
                    <v-col cols="12" class="text-center">
                        <h1>SELECT TRANSACTION</h1>
                    </v-col>
                    <v-col cols="12" sm="12" lg="6">
                        <v-card class="login-box-transparent pa-5" @click="selectType('regular')" hover>
                            <v-list-item>
                                <v-list-item-avatar size="75px" color="transparent">
                                    <v-icon size="50">mdi-timer</v-icon>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                    <v-list-item-title class="headline">Hourly/Daily Plan</v-list-item-title>
                                    <v-list-item-subtitle></v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                        </v-card>
                    </v-col>
                    <v-col cols="12" sm="12" lg="6">
                        <v-card class="login-box-transparent pa-5" @click="selectType('subscription')" hover>
                            <v-list-item>
                                <v-list-item-avatar size="75px" color="transparent">
                                    <v-icon size="50">mdi-calendar</v-icon>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                    <v-list-item-title class="headline">Weekly/Monthly Plan</v-list-item-title>
                                    <v-list-item-subtitle></v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
            <!-- <v-card>
                <v-card-title>
                    <h4>Transaction Type</h4>
                </v-card-title>
                
            </v-card> -->
        </v-col>
        <v-col cols="12" md="5" lg="6" v-if="step == 2">
            
            <v-container v-if="form.type == 'regular'">
                <v-row>
                    <v-col cols="12">
                        <v-row>
                            <v-col cols="6">
                                <h1>SELECT SPACE</h1>
                            </v-col>
                            <v-col cols="6" class="text-right">
                                <v-btn @click="step -= 1" text>Go Back</v-btn>
                            </v-col>
                        </v-row>
                    </v-col>
                    <v-col cols="12" sm="12" lg="6" v-for="space in spaces" :key="space.id">
                        <v-card hover @click="selectedSpace(space)" class="login-box-transparent pa-5">
                            <v-list-item>
                                <v-list-item-avatar size="100px">
                                    <v-icon size="50">{{ space.image }}</v-icon>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                    <v-list-item-title class="headline">{{ space.name }}</v-list-item-title>
                                    <v-list-item-subtitle>Max. of {{ space.capacity }} pax</v-list-item-subtitle>
                                    <v-list-item-subtitle>Hourly Rate: {{ space.rate }}</v-list-item-subtitle>
                                    <v-list-item-subtitle>Daily Rate: {{ space.daily_rate }}</v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>

            <v-card class="login-box-transparent" v-if="form.type == 'subscription'">
                <v-card-title>
                    <h3>Subscription</h3>
                    <v-spacer></v-spacer>
                    <v-btn @click="step -= 1" text>Go Back</v-btn>
                </v-card-title>
                <v-container class="pa-5">
                    <v-row dense>
                        <v-col cols="12">
                            <v-text-field
                                label="Subscription Code"
                                v-model="form.subscription_code"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="4"></v-col>
                        <v-col cols="12">
                            <v-btn @click="clockMeInNow" color="success" block>Clock In</v-btn>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card>
        </v-col>
        <v-col cols="12" md="5" lg="3" v-if="step == 3">
            <v-card :loading="loading.wd" :disabled="loading.wd" class="login-box-transparent">
                <v-card-title>
                    <h3>SELECT PLAN</h3>
                    <v-spacer></v-spacer>
                    <v-btn @click="step -= 1" text>Go Back</v-btn>
                </v-card-title>
                <v-container class="pa-5">
                    <v-row dense>
                        <v-col cols="12">
                            <v-select
                                label="Plans"
                                v-model="form.plan"
                                :items="[
                                    { name: 'Hourly Plan', value: 'HP'},
                                    { name: 'Daily Plan', value: 'DP' }
                                ]"
                                item-text="name"
                                item-value="value"
                                placeholder="Select Plan"
                            ></v-select>
                        </v-col>
                        <v-col cols="12" v-if="form.plan == 'HP'">
                            <v-subheader class="pl-0">Duration: {{ form.duration }} hr(s)</v-subheader>
                            <v-slider
                                v-model="form.duration"
                                min="1"
                                max="6"
                            ></v-slider>
                        </v-col>
                        <v-col cols="12" v-if="spaceSelected.name == 'Conference A' || spaceSelected.name == 'Conference B' || spaceSelected.name == 'Private Suite'">
                            <v-subheader class="pl-0">Pax: {{ form.pax }}</v-subheader>
                            <v-slider
                                v-model="form.pax"
                                :min="minPax"
                                :max="maxPax"
                            ></v-slider>
                        </v-col>
                        <v-col cols="12">
                            <v-checkbox
                                label="With discount card?"
                                v-model="form.discount"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="12">
                            <v-btn :disabled="form.plan ? false : true" @click="clockMeIn()" color="primary" block>{{ form.discount == true ? 'Next' : 'Clock In' }}</v-btn>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card>
        </v-col>
        <v-col cols="12" md="5" lg="3" v-if="step == 4">
            <v-card :loading="loading.dc" :disabled="loading.dc"  class="login-box-transparent">
                <v-card-title>
                    <h3>Discount Card</h3>
                    <v-spacer></v-spacer>
                    <v-btn @click="step -= 1" text>Go Back</v-btn>
                </v-card-title>
                <v-container class="pa-5">
                    <v-row dense>
                        <v-col cols="12">
                            <v-text-field
                                label="Card Control No."
                                v-model="form.control_no"
                                placeholder="123456789012345"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-btn @click="clockMeInNow" color="primary" block>Clock In</v-btn>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        layout: 'client',
        // beforeRouteLeave (to, from, next) {
        //     if (this.$store.getters['auth/isAuthenticated']) {
        //         alert('TRUE');
        //         this.$store.dispatch('auth/logout');
        //         next();
        //     } else {
        //         alert('FALSE')
        //         next();
        //     }
        // },
        data () {
            return {
                spaces: [],
                spaceSelected: [],
                form: {
                    subscription_code: '',
                    type: '',
                    space_id: '',
                    pax: 0,
                    duration: 0,
                    plan: '',
                    control_no: '',
                    discount: false,
                },
                step: 1,
                loading: {
                    dc: false,
                    wd: false
                }
            }
        },
        computed: {
            minPax () {
                switch (this.spaceSelected.name) {
                    case 'Private Suite':
                        return 1;
                        break;

                    case 'Conference A':
                        return 1;
                        break;

                    case 'Conference B':
                        return 1;
                        break;
                }
            },
            maxPax () {
                switch (this.spaceSelected.name) {
                    case 'Private Suite':
                        return 2;
                        break;

                    case 'Conference A':
                        return 10;
                        break;

                    case 'Conference B':
                        return 8;
                        break;
                }
            }
        },
        async mounted () {
            await this.loadSpaces();
        },
        methods: {
            async loadSpaces () {
                await this.$axios.get('/api/space/getAll')
                    .then((response) => {
                        this.spaces = response.data;
                    })  
            },
            selectedSpace (space) {
                this.spaceSelected = space;
                this.form.space_id = space.id;
                this.form.pax = space.capacity;
                this.step += 1;
            },
            selectType (type) {
                this.form.type = type;
                this.step += 1;
            },
            async clockMeIn () {
                if (this.form.discount) {
                    this.step += 1;
                } else {
                    this.loading.wd = true;
                    await this.$axios.post('/api/client/addTransaction', this.form, {
                            headers: {
                                Authorization: `Bearer ${localStorage.getItem('access_token')}`
                            }
                        })
                        .then((response) => {
                            this.loading.wd = false;
                            localStorage.removeItem('access_token');
                            this.$router.push('/auth/login');
                            this.$swal.fire({
                                type: 'success',
                                title: 'Transaction Added.'
                            })
                        })
                        .catch(error => {
                            this.loading.wd = false;
                            console.log(error.response.data);
                            this.$swal.fire({
                                type: 'error',
                                title: error.response.data.message
                            })
                        })
                }
            },
            async clockMeInNow () {
                this.loading.dc = true;
                await this.$axios.post('/api/client/addTransaction', this.form, {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem('access_token')}`
                        }
                    })
                    .then((response) => {
                        this.loading.dc = false;
                        localStorage.removeItem('access_token');
                        this.$router.push('/auth/login');
                        this.$swal.fire({
                            type: 'success',
                            title: 'Transaction Added.'
                        })
                    })
                    .catch(error => {
                        this.loading.dc = false;
                        console.log(error.response.data);
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