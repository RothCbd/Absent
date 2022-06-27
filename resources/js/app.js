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

import VueHtml2pdf from 'vue-html2pdf';
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
            title: 'Absence Management-Login'
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
            title: 'Absence Management-Dashboard',
        }
    },
    {
        path: '/user',
        name:'user',
        component: User,
        meta: {
            requiresAuth: true,
            title: 'Absence Management-User'
        }
    },
    {
        path: '/position',
        name:'position',
        component: Position,
        meta: {
            requiresAuth: true,
            title: 'Absence Management-Position'
        }
    },
    {
        path: '/employee',
        name:'employee',
        component: Employee,
        meta: {
            requiresAuth: true,
            title: 'Absence Management-Employee'
        }
    },
    {
        path: '/absent',
        name:'absent',
        component: Absent,
        meta: {
            requiresAuth: true,
            title: 'Absence Management-Absent'
        }
    },
    ,
    {
        path: '/report',
        name:'report',
        component: Report,
        meta: {
            requiresAuth: true,
            title: 'Absence Management-Report'
        }
    },
    {
        path: '/account',
        name:'account',
        component: Account,
        meta: {
            requiresAuth: true,
            title: 'Absence Management-Account'
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

        login: {
            title: 'ABSENCES MANAGERMENT',
            description: 'Sign in with your email and password:',
            email: 'Email',
            password: 'password',
            login: 'login',
            forgotPass: 'Forgot Password?',
            langKhmer: 'Khmer',
            langEnglish: 'English'
        },

        forgotPass: {
            title: "Forgot your password?",
            description1: "Enter your email address that you used to login.",
            description2: "we'll send you a link to reset your password.",
            email: 'Email',
            backToLogin: 'Back to Login',
            btnResetPass: 'reset password'
        },

        app: {
            title: 'Absence Management',
            monday: 'Monday',
            tuesday: 'Tuesday',
            wednesday: 'Wednesday',
            thursday: 'Thursday',
            friday: 'Friday',
            saturday: 'Saturday',
            sunday: 'Sunday',

            january: 'January',
            february: 'February',
            march: 'March',
            april: 'April',
            may: 'May',
            june: '/06',
            july: 'July',
            august: 'August',
            september: 'September',
            october: 'October',
            november: 'November',
            december: 'December',
        },

        holiday: {
            title: 'Cambodia Public holiday for',
            addHoliday: 'add holiday',
            tbDay: 'Day',
            tbDate: 'Date',
            tbHoliday: 'Holiday',
            tbAction: 'Edit | Delete',

            frmtitleAdd: 'Add Holiday',
            frmtitleEdit: 'Edit Holiday',
            txtHolidayDate: 'Holiday Date',
            txtHolidayDetail: 'Holiday Detail',
            btnCancel: 'cancel',
            btnSave: 'save',

            monday: 'Monday',
            tuesday: 'Tuesday',
            wednesday: 'Wednesday',
            thursday: 'Thursday',
            friday: 'Friday',
            saturday: 'Saturday',
            sunday: 'Sunday',

            january: 'January',
            february: 'February',
            march: 'March',
            april: 'April',
            may: 'May',
            june: 'June',
            july: 'July',
            august: 'August',
            september: 'September',
            october: 'October',
            november: 'November',
            december: 'December',
        },

        menu: {
            dashboard: 'Dashboard',
            position: 'Position',
            employee: 'Employee',
            absent: 'Absent',
            report: 'Report',
            user: 'User',
            account: 'Account',
            signout: 'sign out'
        },

        languages: {
            language: 'Language',
            'english': 'English',
            'khmer': 'Khmer',
        },

        dashboard: {
            title: 'Dashboard',
            users: 'Users',
            employee: 'Employees',
            absent: 'Absent',

            weekly: 'This Week',
            monthly: 'This Month',
            yearly: 'This Year',
            absenceSummary: 'Absence Summary',

            day: 'day',
            fullDay: 'full day',
            halfDay: 'half day',
            monday: 'Monday',
            tuesday: 'Tuesday',
            wednesday: 'Wednesday',
            thursday: 'Thursday',
            friday: 'Friday',
            saturday: 'Saturday',
            sunday: 'Sunday',

            january: 'January',
            february: 'February',
            march: 'March',
            april: 'April',
            may: 'May',
            june: 'June',
            july: 'July',
            august: 'August',
            september: 'September',
            october: 'October',
            november: 'November',
            december: 'December',
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
            btnCancel: 'cancel',
            btnSave: 'save',
            btnDelete: 'delete',
            deleteMessage: 'Are you sure delete position',
            deleteMessageWarning: 'All employee in this positon will be delete too',

            msgClose:'close',
            savedMsg: 'Position has been saved.',
            updateMsg: 'Position has been updated.',
            deleteMsg: 'Position has been deleted.',
        },

        employee: {
            list: 'Employees List',
            search: 'Search',
            btnAddEmp: 'add employee',
            activeEmp: 'Active Employee',
            inctiveEmp: 'Inactive Employee',
            tbName: 'Name',
            tbGender: 'Gender',
            tbGenderM: 'male',
            tbGenderF: 'female',
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

            january: '01',
            february: '02',
            march: '03',
            april: '04',
            may: '05',
            june: '06',
            july: '07',
            august: '08',
            september: '09',
            october: '10',
            november: '11',
            december: '12',

            btnDelete: 'delete',
            deleteMessage: 'Are you sure delete employee',
            msgClose:'close',
            savedMsg: 'Position has been saved.',
            updateMsg: 'Position has been updated.',
            deleteMsg: 'Position has been deleted.',
        },

        absent: {
            listTitle: 'Absent List',
            search: 'Search',
            btnAdd: 'add absent',
            tbEmp: 'Employee',
            tbAbsent: 'Absent',
            tbDay: 'Day',
            tbDate: 'Date',
            tbDescription: 'Description',
            tbEdit_Delete: 'Edit | Delete',
            tbPagination: 'Rows per page',
            tabelNotFound: 'Not Found Data',

            fullDay: 'full day',
            halfDay: 'half day',
            morning: 'morning',
            afternoon: 'afternoon',
            monday: 'Monday',
            tuesday: 'Tuesday',
            wednesday: 'Wednesday',
            thursday: 'Thursday',
            friday: 'Friday',
            saturday: 'Saturday',
            sunday: 'Sunday',

            frmTitleAdd: 'Add Absent',
            frmTitleEdit: 'Edit Absent',
            frmSelect: 'Select Employee',
            frmFullDay: 'Full Day',
            frmHalfDay: 'Half Day',
            frmAbsentDate: 'Absent Date',
            frmMorning: 'Morning',
            frmAfternoon: 'Afternoon',
            frmDescription: 'Description',
            frmCancel: 'cancel',
            frmSave: 'save',

            january: 'January',
            february: 'February',
            march: 'March',
            april: 'April',
            may: 'May',
            june: 'June',
            july: 'July',
            august: 'August',
            september: 'September',
            october: 'October',
            november: 'November',
            december: 'December',

            deleteMsgQ: 'Are you sure?',
            deleteMsgAlert: 'Delete',
            deleteMsgAlertAbsen: "'s absent",
            btnCancel: 'cancel',
            btnDelete: 'Delete',

            deleteMessage: 'Are you sure delete employee',
            msgClose:'close',
            savedMsg: 'Absent has been saved.',
            updateMsg: 'Absent has been updated.',
            deleteMsg: 'Absent has been deleted.',
        },

        report: {
            title:  'Report',
            tbEmployee: 'Employee',
            tbAbsentCount: 'Absent Count',
            tbTotalAbsent: 'Total Absent',
            tbPosition: 'Position',
            tbAbsent: 'Absent',
            tbDay: 'Day',
            tbDate: 'Date',
            tbDescription: 'Description',
            notReport: 'please select date or employee',

            txtDate: 'Choose Date',
            txtSelectEmp: 'Select Employee',
            smgAlert: 'Please choose any Date or Employee.',
            btnReport: 'Report',
            tbPagination: 'Rows per page',

            fullDay: 'full day',
            halfDay: 'half day',
            morning: 'morning',
            afternoon: 'afternoon',
            day: 'day',
            monday: 'Monday',
            tuesday: 'Tuesday',
            wednesday: 'Wednesday',
            thursday: 'Thursday',
            friday: 'Friday',
            saturday: 'Saturday',
            sunday: 'Sunday',

            january: '01',
            february: '02',
            march: '03',
            april: '04',
            may: '05',
            june: '06',
            july: '07',
            august: '08',
            september: '09',
            october: '10',
            november: '11',
            december: '12',

            pdfHeaderTb: 'Absent List',
            pdfTitle: 'Absent Report',
            pdfReportBy: 'Report By',
            pdfDateReport:'Report Date'
        },

        user: {
            listTitle: 'User List',
            btnAdd: 'add user',
            tbName: 'User',
            tbEmail: 'Email',
            tbRole: 'Role',
            tbPhoneNum: 'Phone Number',
            tbUpdate_Delete: 'Edit | Delete',
            tbPagination: 'Rows per page',

            frmTitleAdd: 'Add User',
            txtRole: 'Role',
            txtName: 'Name',
            txtEmail: 'Email',
            txtPhone: 'Phone Number',
            txtPassword: 'Password',
            txtPasswordConfir: 'Password Confirmation',
            txtImage: 'select image',
            btnCancel: 'cancel',
            btnSave: 'save',

            btnDelete: 'Delete',
            deleteMessage: 'Are you sure delete user',
            msgClose:'close',
            savedMsg: 'User has been saved.',
            updateMsg: 'User has been updated.',
            deleteMsg: 'User has been deleted.',
        },

        account: {
            tabAccount: 'Account',
            tabPassword: 'Password',

            txtName: 'Name',
            txtEmail: 'Email',
            Password: 'Password',
            txtPassword: 'Password',
            txtNewPassword: 'New Password',
            txtConfirPassword: 'Confirm Password',
            btnSave: 'save',
            msgClose:'close',
            updateMsg: 'Profile has been updated.',
            passUpdateMsg: 'Password updated please login again.'
        }
    },

    // ============Khmer==============
    khmer: {

        login: {
            title: 'ប្រព័ន្ធគ្រប់គ្រង អវត្តន៏មាន',
            description: 'បំពេញអ៊ីម៉ែល និងពាក្យសំមង្ងាត់របស់អ្នក',
            email: 'អ៊ីម៉ែល',
            password: 'ពាក្យសម្ងាត់',
            login: 'ចូល',
            forgotPass: 'ភ្លេចពាក្យសម្ងាត់?',
            langKhmer: 'ខ្មែរ',
            langEnglish: 'អងគ្លេស'
        },

        forgotPass: {
            title: "ភ្លេចពាក្យសម្ងាត់របស់អ្នក?",
            description1: "បញ្ចូលអ៊ីម៉ែលរបស់អ្នក ដែរអ្នកធ្លាប់ប្រើដើម្បីចូលប្រព័ន្ធ",
            description2: "យើងនិងផ្ញើរដំណភ្ជាប់ទៅអ្នក ដើម្បីផ្លាស់ប្តូរពា្យសម្ងាត់របស់អ្នក",
            email: 'អ៊ីម៉ែល',
            backToLogin: 'ត្រឡប់ទៅទំព័រមុន',
            btnResetPass: 'ផ្លាស់ប្តូរពាក្យសម្ងាត់'
        },

        app: {
            title: 'គ្រប់គ្រង អវត្តន៏មាន',
            monday: 'ថ្ងៃចន្ទ',
            tuesday: 'អង្គារ',
            wednesday: 'ពុធ',
            thursday: 'ព្រហស្បតិ៍',
            friday: 'សុក្រ',
            saturday: 'សៅរ៍',
            sunday: 'អាទិត្យ',

            january: 'ខែមករា',
            february: 'ខែកុម្ភះ',
            march: 'ខែមិនា',
            april: 'ខែមេសា',
            may: 'ខែឧសភា',
            june: 'ខែមិថុនា',
            july: 'ខែកក្កដា',
            august: 'ខែសីហា',
            september: 'ខែកញ្ញា',
            october: 'ខែតុលា',
            november: 'ខែវិច្ឆកា',
            december: 'ខែធ្នូ',
        },

        holiday: {
            title: 'ថ្ងៃបុណ្យជាតិឈប់សំរាកសំរាប់ឆ្នាំ',
            addHoliday: 'បន្ថែមថ្ងៃឈប់សំរាក',
            tbDay: 'ថ្ងៃ',
            tbDate: 'ថ្ងៃខែឆ្នាំ',
            tbHoliday: 'ឈប់សំរាក',
            tbAction: 'កែប្រែ | លុប',

            frmtitleAdd: 'បន្ថែមថ្ងៃឈប់សំរាក',
            frmtitleEdit: 'កែប្រែថ្ងៃឈប់សំរាក',
            txtHolidayDate: 'កាលបរិច្ឆេទ ថ្ងៃឈប់សំរាក',
            txtHolidayDetail: 'ព័ត៌មានលម្អិតនៃថ្ងៃឈប់សម្រាក',
            btnCancel: 'បោះបង់',
            btnSave: 'រក្សាទុក',

            monday: 'ថ្ងៃចន្ទ',
            tuesday: 'អង្គារ',
            wednesday: 'ពុធ',
            thursday: 'ព្រហស្បតិ៍',
            friday: 'សុក្រ',
            saturday: 'សៅរ៍',
            sunday: 'អាទិត្យ',

            january: 'ខែមករា',
            february: 'ខែកុម្ភះ',
            march: 'ខែមិនា',
            april: 'ខែមេសា',
            may: 'ខែឧសភា',
            june: 'ខែមិថុនា',
            july: 'ខែកក្កដា',
            august: 'ខែសីហា',
            september: 'ខែកញ្ញា',
            october: 'ខែតុលា',
            november: 'ខែវិច្ឆកា',
            december: 'ខែធ្នូ',
        },

        menu: {
            dashboard: 'ផ្ទាំងគ្រប់គ្រង',
            position: 'មុខដំណែង',
            employee: 'បុគ្គលិក',
            absent: 'អវត្តន៏មាន',
            report: 'របាយការណ៍',
            user: 'អ្នកប្រើប្រាស់',
            account: 'គណនី',
            signout: 'ចាកចេញ'
        },

        languages: {
            language: 'ភាសារ',
            'english': 'អងគ្លេស',
            'khmer': 'ខ្មែរ',
        },

        dashboard: {
            title: 'ផ្ទាំងទិន្នន័យ',
            users: 'អ្នកប្រើប្រាស់',

            employee: 'បុគ្គលិក',
            absent: 'អវត្តន៏មាន',

            weekly: 'សប្តាហ៍នេះ',
            monthly: 'ខែនេះ',
            yearly: 'ឆ្នាំនេះ',
            absenceSummary: 'សង្ខេបអវត្តមាន',

            day: 'ថ្ងៃ',
            fullDay: 'មួយថ្ងៃ',
            halfDay: 'កន្លះថ្ងៃ',
            morning: 'ពេលព្រឹក',
            afternoon: 'ពេលរសៀល',
            monday: 'ចន្ទ',
            tuesday: 'អង្គារ',
            wednesday: 'ពុធ',
            thursday: 'ព្រហស្បតិ៍',
            friday: 'សុក្រ',
            saturday: 'សៅរ៍',
            sunday: 'អាទិត្យ',

            january: 'មករា',
            february: 'កុម្ភះ',
            march: 'មិនា',
            april: 'មេសា',
            may: 'ឧសភា',
            june: 'មិថុនា',
            july: 'កក្កដា',
            august: 'សីហា',
            september: 'កញ្ញា',
            october: 'តុលា',
            november: 'វិច្ឆកា',
            december: 'ធ្នូ',
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

            msgClose:'បិត',
            savedMsg: 'មុខដំណែងត្រូវបានរក្សាទុក',
            updateMsg: 'មុខដំណែងត្រូវបានកែប្រែ',
            deleteMsg: 'មុខដំណែងត្រូវបានលុប',
        },

        employee: {
            list: 'តារាងបុគ្គលិក',
            search: 'ស្វែងរក',
            btnAddEmp: 'បន្ថែម បុគ្គលិក',
            activeEmp: 'បុគ្គលិក នៅបំរើការងារ',
            inctiveEmp: 'បុគ្គលិក ឈប់ពីការងារ',
            tbName: 'ឈ្មោះ',
            tbGender: 'ភេទ',
            tbGenderM: 'ប្រុស',
            tbGenderF: 'ស្រី',
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

            january: 'មករា',
            february: 'កុម្ភះ',
            march: 'មិនា',
            april: 'មេសា',
            may: 'ឧសភា',
            june: 'មិថុនា',
            july: 'កក្កដា',
            august: 'សីហា',
            september: 'កញ្ញា',
            october: 'តុលា',
            november: 'វិច្ឆកា',
            december: 'ធ្នូ',

            btnDelete: 'លុប',
            deleteMessage: 'តើអ្នកពិតជាច្បាស់ថានិងលុបបុគ្គលិក',
            msgClose:'បិត',
            savedMsg: 'បុគ្គលិកត្រូវបានរក្សាទុក',
            updateMsg: 'បុគ្គលិកត្រូវបានកែប្រែ',
            deleteMsg: 'បុគ្គលិកត្រូវបានលុប',
        },

        absent: {
            listTitle: 'តារាងអវត្តន៏មាន',
            search: 'ស្វែងរក',
            btnAdd: 'បន្ថែម អវត្តន៏មាន',
            tbEmp: 'បុគ្គលិក',
            tbAbsent: 'អវត្តន៏មាន',
            tbDay: 'ថ្ងៃ',
            tbDate: 'ថ្ងៃខែឆ្នាំ',
            tbDescription: 'ពិពណ៌នា',
            tbEdit_Delete: 'កែ | លុប',
            tbPagination: 'ចំនួនជួរនៃមួយទំព័រ',
            tabelNotFound: 'មិនមានទិន្ន័យ',

            fullDay: 'ពេញមួយថ្ងៃ',
            halfDay: 'កន្លះថ្ងៃ',
            morning: 'ពេលព្រឹក',
            afternoon: 'ពេលរសៀល',
            monday: 'ថ្ងៃចន្ទ',
            tuesday: 'ថ្ងៃអង្គារ',
            wednesday: 'ថ្ងៃពុធ',
            thursday: 'ថ្ងៃព្រហស្បតិ៍',
            friday: 'ថ្ងៃសុក្រ',
            saturday: 'ថ្ងៃសៅរ៍',
            sunday: 'ថ្ងៃអាទិត្យ',

            frmTitleAdd: 'បន្ថែមអវត្តន៏មាន',
            frmTitleEdit: 'កែប្រែអវត្តន៏មាន',
            frmSelect: 'ជ្រើសរើសបុគ្គលិក',
            frmFullDay: 'ពេញមួយថ្ងៃ',
            frmHalfDay: 'កន្លះថ្ងៃ',
            frmAbsentDate: 'ថ្ងៃខែ អវត្តន៏មាន',
            frmMorning: 'ពេលព្រឹក',
            frmAfternoon: 'ពេលរសៀល',
            frmDescription: 'ពិពណ៌នា',
            frmCancel: 'បោះបង់',
            frmSave: 'រក្សាទុក',

            january: 'មករា',
            february: 'កុម្ភះ',
            march: 'មិនា',
            april: 'មេសា',
            may: 'ឧសភា',
            june: 'មិថុនា',
            july: 'កក្កដា',
            august: 'សីហា',
            september: 'កញ្ញា',
            october: 'តុលា',
            november: 'វិច្ឆកា',
            december: 'ធ្នូ',

            deleteMsgQ: 'តើអ្នកប្រាកដដែរឬទេ?',
            deleteMsgAlert: 'លុបអវត្តន៏មានរបស់',
            deleteMsgAlertAbsen: "",
            btnCancel: 'បោះបង់',
            btnDelete: 'លុប',

            msgClose:'បិត',
            savedMsg: 'អវត្តន៏មានត្រូវបានរក្សាទុក',
            updateMsg: 'អវត្តន៏មានត្រូវបានកែប្រែ',
            deleteMsg: 'អវត្តន៏មានត្រូវបានលុប',
        },

        report: {
            title: 'របាយការណ៍',
            tbEmployee: 'បុគ្គលិក',
            tbAbsentCount: 'ចំនួន អវត្តន៏មាន',
            tbTotalAbsent: 'អវត្តន៏មានសរុប(ថ្ងៃ)',
            tbPosition: 'មុខដំណែង',
            tbAbsent: 'អវត្តន៏មាន',
            tbDay: 'ថ្ងៃ',
            tbDate: 'ថ្ងៃខែឆ្នាំ',
            tbDescription: 'ពិពណ៌នា',
            tbPagination: 'ចំនួនជួរនៃមួយទំព័រ',
            notReport: 'សូមជ្រើសរើស ថ្ងៃខែឬបុគ្គលិក ដើម្បីបង្ហាញលទ្ធផល',

            txtDate: 'ជ្រើសរើសថ្ងៃខែ',
            txtSelectEmp: 'ជ្រើសរើសបុគ្គលិក',
            smgAlert: 'សូមជ្រើសរើស ថ្ងៃខែណាមួយឬបុគ្គលិកណាម្នាក់',
            btnReport: 'របាយការណ៍',

            fullDay: 'ពេញមួយថ្ងៃ',
            halfDay: 'កន្លះថ្ងៃ',
            morning: 'ពេលព្រឹក',
            afternoon: 'ពេលរសៀល',
            day: 'ថ្ងៃ',
            monday: 'ថ្ងៃចន្ទ',
            tuesday: 'ថ្ងៃអង្គារ',
            wednesday: 'ថ្ងៃពុធ',
            thursday: 'ថ្ងៃព្រហស្បតិ៍',
            friday: 'ថ្ងៃសុក្រ',
            saturday: 'ថ្ងៃសៅរ៍',
            sunday: 'ថ្ងៃអាទិត្យ',

            january: 'មករា',
            february: 'កុម្ភះ',
            march: 'មិនា',
            april: 'មេសា',
            may: 'ឧសភា',
            june: 'មិថុនា',
            july: 'កក្កដា',
            august: 'សីហា',
            september: 'កញ្ញា',
            october: 'តុលា',
            november: 'វិច្ឆកា',
            december: 'ធ្នូ',

            pdfHeaderTb: 'តារាងអវត្តន៏មាន',
            pdfTitle: 'របាយការណ៍ អវត្តន៏មាន',
            pdfReportBy: 'ចេញរបាយការណ៍ដោយ',
            pdfDateReport:'ថ្ងៃខែចេញរបាយការណ៍'
        },

        user: {
            listTitle: 'តារាងអ្នកប្រើប្រាស់',
            btnAdd: 'បន្ថែម អ្នកប្រើប្រាស់',
            tbName: 'អ្នកប្រើប្រាស់',
            tbEmail: 'អ៊ីមែល',
            tbRole: 'តួនាទី',
            tbPhoneNum: 'លេខទូរស័ព្ទ',
            tbUpdate_Delete: 'កែប្រែ | លុប',
            tbPagination: 'ចំនួនជួរនៃមួយទំព័រ',

            frmTitleAdd: 'បន្ថែម អ្នកប្រើប្រាស់',
            txtRole: 'តួនាទី',
            txtName: 'ឈ្មោះ',
            txtEmail: 'អ៊ីមែល',
            txtPhone: 'លេខទូរស័ព្ទ',
            txtPassword: 'ពាក្យសម្ងាត់',
            txtPasswordConfir: 'បញ្ជាក់ ពាក្យសម្ងាត់',
            txtImage: 'ជ្រើសរើសរូបភាព',
            btnCancel: 'បោះបង់',
            btnSave: 'រក្សាទុក',

            btnDelete: 'លុប',
            deleteMessage: 'តើអ្នកពិតជាច្បាស់ថានិងអ្នកប្រើប្រាស់',
            msgClose:'បិត',
            savedMsg: 'អ្នកប្រើប្រាស់ត្រូវបានរក្សាទុក',
            updateMsg: 'អ្នកប្រើប្រាស់ត្រូវបានកែប្រែ',
            deleteMsg: 'អ្នកប្រើប្រាស់ត្រូវបានលុប',
        },

        account: {
            tabAccount: 'គណនី',
            tabPassword: 'ពាក្យសម្ងាត់',

            txtName: 'ឈ្មោះ',
            txtEmail: 'អ៊ីមែល',
            Password: 'ពាក្យសម្ងាត់',
            txtPassword: 'ពាក្យសម្ងាត់',
            txtNewPassword: 'ពាក្យសម្ងាត់ថ្មី',
            txtConfirPassword: 'បញ្ជាក់ ពាក្យសម្ងាត់',
            btnSave: 'រក្សាទុក',

            msgClose:'បិត',
            updateMsg: 'គណនីត្រូវបានកែប្រែ',
            passUpdateMsg: 'ពាក្យសម្ងាត់ត្រូវបានកែប្រែ សូមធ្វើការចូលប្រព័ន្ធម្តងទៀត'
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
