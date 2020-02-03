import Vue from 'vue';
import VueRouter from 'vue-router';
import {store} from '@/stores/store.js';
import swal from 'sweetalert2';
// Auth Pages
import Login from '@/pages/auth/LoginPage.vue';
import Register from '@/pages/auth/RegisterPage.vue';
import AdminLogin from '@/pages/auth/AdminLoginPage.vue';
import PasswordReset from '@/pages/auth/PasswordResetPage.vue';
// Client Pages
import ClientDashboard from '@/pages/client/DashboardPage.vue';
// Admin Pages
import AdminDashboard from '@/pages/admin/DashboardPage.vue';
import AdminTransactionPage from '@/pages/admin/TransactionPage.vue';
import AdminOtherService from '@/pages/admin/OtherServicePage.vue';
import AdminSubscriptionPage from '@/pages/admin/SubscriptionPage.vue';
import AdminCardPage from '@/pages/admin/CardPage.vue';
import AdminSpacePage from '@/pages/admin/SpacePage.vue';
import AdminAmenitiesPage from '@/pages/admin/AmenitiesPage.vue';
import AdminOverallTransactionPage from '@/pages/admin/OverallTransactionPage.vue';
import AdminOverallServicePage from '@/pages/admin/OverallOtherServicePage.vue';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '*',
            redirect: '/auth/login'
        },
        // Client Routes
        {
            path: '/client/dashboard',
            name: 'client-dashboard',
            component: ClientDashboard,
            beforeEnter: (to, from, next) => {
                if (localStorage.getItem('access_token')) {
                    next();
                } else {
                    next('/auth/login');
                }
            }
        },
        // Admin Routes
        {
            path: '/admin/dashboard',
            name: 'admin-dashboard',
            component: AdminDashboard,
            beforeEnter: (to, from , next) => {
                if (localStorage.getItem('access')) {
                    next();
                } else {
                    next('/auth/admin/login');
                }
            }
        },
        {
            path: '/admin/transactions',
            name: 'admin-transaction',
            component: AdminTransactionPage,
            beforeEnter: (to, from , next) => {
                if (localStorage.getItem('access')) {
                    next();
                } else {
                    next('/auth/admin/login');
                }
            }
        },
        {
            path: '/admin/other-service',
            name: 'admin-other-service',
            component: AdminOtherService,
            beforeEnter: (to, from ,next) => {
                if (localStorage.getItem('access')) {
                    next();
                } else {
                    next('/auth/admin/login');
                }
            }
        },
        {
            path: '/admin/subscriptions',
            name: 'admin-subscription',
            component: AdminSubscriptionPage,
            beforeEnter: (to, from , next) => {
                if (localStorage.getItem('access')) {
                    next();
                } else {
                    next('/auth/admin/login');
                }
            }
        },
        {
            path: '/admin/cards',
            name: 'admin-cards',
            component: AdminCardPage,
            beforeEnter: (to, from , next) => {
                if (localStorage.getItem('access')) {
                    next();
                } else {
                    next('/auth/admin/login');
                }
            }
        },
        {
            path: '/admin/spaces',
            name: 'admin-spaces',
            component: AdminSpacePage,
            beforeEnter: (to, from , next) => {
                if (localStorage.getItem('access')) {
                    next();
                } else {
                    next('/auth/admin/login');
                }
            }
        },
        {
            path: '/admin/amenities',
            name: 'admin-amenities',
            component: AdminAmenitiesPage,
            beforeEnter: (to, from , next) => {
                if (localStorage.getItem('access')) {
                    next();
                } else {
                    next('/auth/admin/login');
                }
            }
        },
        {
            path: '/admin/overall/transactions',
            name: 'admin-overall-transactions',
            component: AdminOverallTransactionPage,
            beforeEnter: async (to, from, next) => {
                const { value: password } = await swal.fire({
                    title: 'Enter your password',
                    input: 'password',
                    inputPlaceholder: 'Enter your password',
                    inputAttributes: {
                      maxlength: 10,
                      autocapitalize: 'off',
                      autocorrect: 'off'
                    }
                  })
                  
                  if (password == '123456') {
                    if (localStorage.getItem('access')) {
                        next();
                    } else {
                        next('/auth/admin/login');
                    }
                  } else {
                      swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                      })
                  }
            }
        },
        {
            path: '/admin/overall/services',
            name: 'admin-overall-services',
            component: AdminOverallServicePage,
            beforeEnter: async (to, from, next) => {
                const { value: password } = await swal.fire({
                    title: 'Enter your password',
                    input: 'password',
                    inputPlaceholder: 'Enter your password',
                    inputAttributes: {
                      maxlength: 10,
                      autocapitalize: 'off',
                      autocorrect: 'off'
                    }
                  })
                  
                  if (password == '123456') {
                    if (localStorage.getItem('access')) {
                        next();
                    } else {
                        next('/auth/admin/login');
                    }
                  } else {
                      swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                      })
                  }
            }
        },
        // Auth Routes
        {
            path: '/auth/admin/login',
            name: 'admin-login',
            component: AdminLogin
        },
        {
            path: '/auth/login',
            name: 'login',
            component: Login
        },
        {
            path: '/auth/register',
            name: 'register',
            component: Register
        },
        {
            path: '/auth/password-reset',
            name: 'password-reset',
            component: PasswordReset
        }
    ]
})

router.beforeEach((to, from ,next) => {
    if (to.matched.some(layout => layout.components.default.layout)) {
        store.dispatch('global/setLayout', to.matched[0].components.default.layout);
        next();  
    } else {
        localStorage.setItem('layout', 'default');
        next();   
    }
})
export default router;