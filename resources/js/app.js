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

import VueI18n from 'vue-i18n';
Vue.use(VueI18n)

import { Form } from 'vform';
window.Form = Form;

import Login from './components/auth/Login';
import ForgotPassword from './components/ForgotPassword';

import ResetPassword from './components/auth/ResetPassword'

import Dashboard from './components/Dashboard';
import User from './components/User';
import Position from './components/Position';
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
            requiresVisitor: true,
            title: 'Login'
        }
    },

    {
        path: '/forgotPassword',
        name:'forgotPassword',
        component: ForgotPassword,
        meta: {
            requiresVisitor: true,
            title: 'Forgot-Password'
        }
    },

    {
        path: '/reset-password',
        name:'reset-password',
        component: ResetPassword,
        meta: {
            requiresVisitor: true,
            title: 'Reset-Password'
        }
    },

    {
        path: '/',
        name:'dashboard',
        component: Dashboard,
        meta: {
            requiresAuth: true,
            title: 'Dashboard',
        }
    },
    {
        path: '/user',
        name:'user',
        component: User,
        meta: {
            requiresAuth: true,
            title: 'User'
        }
    },
    {
        path: '/position',
        name:'position',
        component: Position,
        meta: {
            requiresAuth: true,
            title: 'Position'
        }
    },
    {
        path: '/employee',
        name:'employee',
        component: Employee,
        meta: {
            requiresAuth: true,
            title: 'Employee'
        }
    },
    {
        path: '/absent',
        name:'absent',
        component: Absent,
        meta: {
            requiresAuth: true,
            title: 'Absent'
        }
    },
    ,
    {
        path: '/report',
        name:'report',
        component: Report,
        meta: {
            requiresAuth: true,
            title: 'Report'
        }
    },
    {
        path: '/account',
        name:'account',
        component: Account,
        meta: {
            requiresAuth: true,
            title: 'Account'
        }
    },
];

const router = new VueRouter({
    // mode: 'history',
    routes
});

router.afterEach((to, from) => {
    Vue.nextTick(() => {
        document.title = to.meta.title;
    });
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

const messages = {
    english: {

        app: {
            title: 'Absence Management'
        },

        languages: {
            language: 'Language',
            'english': 'English',
            'khmer': 'Khmer',
        },

        position: {
            titleList: 'Position List',
            search: 'Search',
            addPosition: 'add position',
            positionTable: 'Position',
            tabelNotFound: 'Not Found Data',
            employeeCountTable: 'Employee',
            edit_delete: 'Edit | Delete',
            tablePagination: 'Rows per page',
            positionEmpProfile: 'Profile',
            positionEmpName: 'Name',
            formTitleAdd: 'Add Position',
            formTitleEdit: 'Edit Position',
            txtPosition: 'Position Name',
            btnCancel: 'ancel',
            btnSave: 'save',
            btnDelete: 'delete',
            deleteMessage: 'Are you sure delete position',
            deleteMessageWarning: 'All employee in this positon will be delete too',
        },

        employee: {
            list: 'Employees List',
            search: 'Search',
            btnAddEmp: 'add employee',
            activeEmp: 'Active Employee',
            inctiveEmp: 'Inactive Employee',
            tbName: 'Name',
            tbGender: 'Gender',
            tbEmail: 'Email',
            tbPosition: 'Position',
            tbStartDate: 'Start Date',
            tbStartStopDate: 'Date Sarted | Stopped',
            tbPhoneNum: 'Phone Number',
            tbEditDelete: 'edit | delete',
            tabelNotFound: 'Not Found Data',
            tablePagination: 'Rows per page',

            frmAddEmp: 'Add Employee',
            frmEditEmp: 'Edit Employee',
            txtName: 'Name',
            genderF: 'Female',
            genderM: 'Male',
            txtEmail: 'Email',
            selectPosition: 'Select Position',
            txtStartDate: 'Start Date',
            txtPhoneNum: 'Phone Number',
            btnCancel: 'cancel',
            btnSave: 'save',
            empImage: 'Employee Image',
            isInactive: 'Is Inactive',
            leavedDate: 'Leave Date',
        }
    },

    // ============Khmer==============
    khmer: {

        app: {
            title: 'គ្រប់គ្រង អវត្តន៏មាន'
        },

        languages: {
            language: 'ភាសារ',
            'english': 'អងគ្លេស',
            'khmer': 'ខ្មែរ',
        },

        position: {
            titleList: 'តារាងមុខតំណែង',
            search: 'ស្វែងរក',
            addPosition: 'បន្ថែម មុខដំណែង',
            tabelNotFound: 'មិនមានទិន្ន័យ',
            positionTable: 'មុខដំណែង',
            employeeCountTable: 'បុគ្គលិក',
            edit_delete: 'កែ | លុប',
            tablePagination: 'ចំនួនជួរនៃមួយទំព័រ',
            positionEmpProfile: 'រូបឬឈ្មោះកាត់',
            positionEmpName: 'ឈ្មោះបុគ្គលិក',
            formTitleAdd: 'បន្ថែម​ មុខដំណែង',
            formTitleEdit: 'កែប្រែ មុខដំណែង',
            txtPosition: 'ឈ្មោះមុខដំណែង',
            btnCancel: 'បោះបង់',
            btnSave: 'រក្សាទុក',
            btnDelete: 'លុប',
            deleteMessage: 'តើអ្នកពិតជាច្បាស់ថានិងលុប មុខដំណែង',
            deleteMessageWarning: 'បុគ្គលិកទាំងអស់ដែរកាន់មុខដំណែងនេះ និងត្រូវលុបទាំងអស់ផងដែរ',
        },

        employee: {
            list: 'តារាងបុគ្គលិក',
            search: 'ស្វែងរក',
            btnAddEmp: 'បន្ថែម បុគ្គលិក',
            activeEmp: 'បុគ្គលិក នៅបំរើការ',
            inctiveEmp: 'បុគ្គលិក លាឈប់',
            tbName: 'ឈ្មោះ',
            tbGender: 'ភេទ',
            tbEmail: 'អ៊ីម៉ែល',
            tbPosition: 'មុខដំណែង',
            tbStartDate: 'ថ្ងៃចូលធ្វើការ',
            tbStartStopDate: 'ថ្ងៃចូល | ថ្ងៃឈប់',
            tbPhoneNum: 'លេខទូរស័ព្ទ',
            tbEditDelete: 'កែ | លុប',
            tabelNotFound: 'មិនមានទិន្ន័យ',
            tablePagination: 'ចំនួនជួរនៃមួយទំព័រ',

            frmAddEmp: 'បន្ថែម បុគ្គលិក',
            frmEditEmp: 'កែប្រែ បុគ្គលិក',
            txtName: 'ឈ្មោះ',
            genderF: 'ភេទស្រី',
            genderM: 'ភេទប្រុស',
            txtEmail: 'អ៊ីម៉ែល',
            selectPosition: 'ជ្រើសរើស មុខដំណែង',
            txtStartDate: 'ថ្ងៃចូលធ្វើការ',
            txtPhoneNum: 'លេខទូរស័ព្ទ',
            btnCancel: 'បោះបង់',
            btnSave: 'រក្សាទុក',
            empImage: 'ជ្រើសរើសរូបបុគ្គលិក',
            isInactive: 'ឈប់ពីការងារ',
            leavedDate: 'ថ្ងៃឈប់ពីការងា',
        }

    }
};

const i18n = new VueI18n({
    locale: 'english',
    messages
});

Vue.component('main-component', require('./components/MainApp.vue').default);

const app = new Vue({
    el: '#app',
    store,
    vuetify: Vuetify,
    router,
    i18n,
});
