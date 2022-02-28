window.Vue = require('vue').default;
window.axios = require('axios');
import Vue from 'vue';
import store from './store';

Vue.config.productionTip = false;
import Vuetify from '../plugins/vuetify';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import 'viewerjs/dist/viewer.css';
import Viewer from 'v-viewer';
Vue.use(Viewer)

import VueMask from 'v-mask'
Vue.use(VueMask);

import mixins from 'vuetify-multiple-draggable-dialogs';
Vue.mixin(mixins);

import VueHtml2pdf from 'vue-html2pdf'
Vue.use(VueHtml2pdf)

import "chart.js";
import "hchs-vue-charts";
Vue.use(window.VueCharts);

import { Form } from 'vform';
window.Form = Form;

import Login from './components/auth/Login';
import ForgotPassword from './components/ForgotPassword';

import ResetPassword from './components/auth/ResetPassword'

import Dashboard from './components/Dashboard';
import User from './components/User';
import Employee from './components/Employee';
import Absent from './components/Absent';
import Report from './components/Report';
import Account from './components/Account';

let routes = [
    {
        path: '/login',
        name:'login',
        component: Login,
        meta: {
            requiresVisitor: true
        }
    },

    {
        path: '/forgotPassword',
        name:'forgotPassword',
        component: ForgotPassword,
        meta: {
            requiresVisitor: true
        }
    },

    // ---------------ResetPassword--------------------
    {
        path: '/reset-password',
        name:'reset-password',
        component: ResetPassword,
        meta: {
            requiresVisitor: true
        }
    },
    // -----------------------------------------------

    {
        path: '/',
        name:'dashboard',
        component: Dashboard,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/user',
        name:'user',
        component: User,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/employee',
        name:'employee',
        component: Employee,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/absent',
        name:'absent',
        component: Absent,
        meta: {
            requiresAuth: true
        }
    },
    ,
    {
        path: '/report',
        name:'report',
        component: Report,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/account',
        name:'account',
        component: Account,
        meta: {
            requiresAuth: true
        }
    },
];

const router = new VueRouter({
    // mode: 'history',
    routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
      if (!store.getters.loggedIn) {
        next({ name: 'login'})
      } else {
        next()
      }
    } if (to.matched.some(record => record.meta.requiresVisitor)) {
        if (store.getters.loggedIn) {
          next({ name: '/'})
        } else {
          next()
        }
      }else {
      next()
    }
})

Vue.component('main-component', require('./components/MainApp.vue').default);

const app = new Vue({
    el: '#app',
    store,
    vuetify: Vuetify,
    router
});
