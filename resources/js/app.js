import './bootstrap';
import Vue from 'vue';
import axios from 'axios';
import VueSweetalert2 from 'vue-sweetalert2';
import JsonExcel from 'vue-json-excel';
import 'sweetalert2/dist/sweetalert2.min.css';

import vuetify from '@/plugins/vuetify.js';
import { store } from '@/stores/store.js';

import Routes from '@/routes.js';
import App from '@/views/App';

import AuthLayout from '@/layouts/AuthLayout.vue';
import ClientLayout from '@/layouts/ClientLayout.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import DefaultLayout from '@/layouts/DefaultLayout.vue';

Vue.component('downloadExcel', JsonExcel);
Vue.component('auth', AuthLayout);
Vue.component('admin', AdminLayout);
Vue.component('client', ClientLayout);
Vue.component('default', DefaultLayout);

Vue.prototype.$axios = axios;
Vue.prototype.$store = store;

Vue.use(store);
Vue.use(VueSweetalert2);

const app = new Vue({
    el: '#app',
    vuetify,
    store,
    router: Routes,
    render: h => h(App)
});

export default app;