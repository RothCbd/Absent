window.Vue = require('vue').default;
window.axios = require('axios');
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

import Vue from 'vue';
import Dashboard from './components/Dashboard';
import User from './components/User';
import Employee from './components/Employee';
import Absent from './components/Absent';
import Report from './components/Report';
import Account from './components/Account';

let routes = [
    {
        path: '/dashboard',
        name:'dashboard',
        component: Dashboard,
    },
    {
        path: '/user',
        name:'user',
        component: User,
    },
    {
        path: '/employee',
        name:'employee',
        component: Employee,
    },
    {
        path: '/absent',
        name:'absent',
        component: Absent,
    },
    ,
    {
        path: '/report',
        name:'report',
        component: Report,
    },
    {
        path: '/account',
        name:'account',
        component: Account,
    },
];

const router = new VueRouter({
    // mode: 'history',
    routes
});

Vue.component('main-component', require('./components/MainApp.vue').default);

const app = new Vue({
    el: '#app',
    vuetify: Vuetify,
    router
});
