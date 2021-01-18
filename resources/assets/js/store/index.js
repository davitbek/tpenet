import Vue from 'vue'
import Vuex from 'vuex'

import auth from './auth/reducers';
import user from './user/reducers';







Vue.use(Vuex);


export default new Vuex.Store({
    modules: {
        auth,
        user,

    }
})
