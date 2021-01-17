import Vue from 'vue';
import Router from 'vue-router';
import Middleware, { middleware } from 'vue-router-middleware';


import { i18n } from "../app";
import Login from '../pages/auth/Login';

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
                    name: 'login',
                    path: 'login',
                    component: Login,
                    meta: {
                    }
                },
            ]
        },
    ]
});

const authenticated = () => {
    return (!!SessionService.get('token') || !!SessionService.get('refreshToken'));
};

Vue.use(Middleware, {
    router,
    middlewares: {
        guest(params, to, from, next) {
            if (authenticated()) {
                next({ name: 'home' });
            } else {
                next();
            }
        },
        auth(params, to, from, next) {
            if (authenticated()) {
                next();
            } else {
                next({ name: 'login' })
            }
        },
    },
});

export default router;
