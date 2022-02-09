window.Vue = require('vue').default;
import Vuetify from '../plugins/vuetify';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Vue from 'vue';
import Dashboard from './components/Dashboard';
import User from './components/User';
import Employee from './components/Employee';
import Absent from './components/Absent';
import Report from './components/Report';

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
    {
        path: '/report',
        name:'report',
        component: Report,
    },
];

const router = new VueRouter({
    routes
});

Vue.component('main-component', require('./components/MainApp.vue').default);

const app = new Vue({
    el: '#app',
    vuetify: Vuetify,
    router
});
