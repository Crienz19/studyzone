import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

// Modules 
import auth from '@/stores/modules/auth.js';
import card from '@/stores/modules/card.js';
import subscription from '@/stores/modules/subscription.js';
import transaction from '@/stores/modules/transaction.js';
import space from '@/stores/modules/space.js';
import amenities from '@/stores/modules/amenities.js';
import service from '@/stores/modules/service.js';
import global from '@/stores/modules/global.js';

export const store = new Vuex.Store({
    modules: {
        global,
        auth,
        card,
        service,
        space,
        subscription,
        transaction,
        amenities
    }
});
