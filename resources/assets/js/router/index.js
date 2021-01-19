import Vue from 'vue';
import Router from 'vue-router';


import { i18n } from "../app";
import Login from '../pages/auth/Login';
import Register from "../pages/auth/Register";
import Reset from "../pages/auth/passwords/Reset";
import Home from "../pages/home/Home";

Vue.use(Router);


const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            component: {
                render: h => h('router-view')
            },

            children: [
                {
                    name: 'home',
                    path: '/',
                    component: Home,
                    meta: {
                    }
                },
                {
                    name: 'login',
                    path: 'login',
                    component: Login,
                    meta: {
                    }
                },
                {
                    name: 'register',
                    path: 'register',
                    component: Register,
                    meta: {
                    }
                },
                {
                    name: 'reset',
                    path: 'reset-password',
                    component: Reset,
                    meta: {
                    }
                },
            ]
        },
    ]
});

export default router
