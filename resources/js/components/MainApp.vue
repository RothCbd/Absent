<template>
    <div>
        <v-app v-if="!loggedIn">
        <v-container class="login-container" fill-height fluid>
            <router-view />
        </v-container>
        </v-app>

        <v-app v-if="loggedIn" id="main-app">
            <v-navigation-drawer color="grey lighten-5" app v-model="drawer">
                <v-card flat class="menu-card khawin-background-color">
                    <v-list class="profile">
                        <v-list-item link class="text-center p-0">
                        <v-list-item-content>
                            <v-list-item-title>
                            <v-avatar color="grey lighten-5" size="50">
                                <span
                                    v-if="auth.profile == 'default.png'"
                                    class="
                                        blue--text
                                        text--lighten-1
                                        headline-1
                                        font-weight-medium
                                    "
                                >
                                    {{
                                        auth.name
                                        .split(" ")
                                        .map((x) => x[0].toUpperCase())
                                        .join("")
                                    }}
                                </span>

                                <v-img v-else :src="'/profiles/' + auth.profile" />
                            </v-avatar>
                            <h5
                                class="
                                    mt-2
                                    mb-0
                                    white--text
                                    text--darken-1
                                    font-weight-regular
                                "
                            >
                                {{ auth.name }}
                            </h5>
                            </v-list-item-title>
                            <v-list-item-subtitle class="white--text text--darken-1">{{
                            auth.email
                            }}</v-list-item-subtitle>

                            <!-- <p class="white--text">{{ auth.name }}</p> -->
                        </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-card>

                <!-- ------list------ -->
                <v-list dense class="menu-icon khmer-font font-weight-bold">
                    <v-list-item link to="/">
                        <v-list-item-action>
                        <v-icon>mdi-view-dashboard</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                        <v-list-item-title>{{ $t('menu.dashboard') }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item link to="/position">
                        <v-list-item-action>
                        <v-icon x-small>mdi-badge-account-outline</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                        <v-list-item-title>{{ $t('menu.position') }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item link to="/employee">
                        <v-list-item-action>
                        <v-icon>mdi-account-tie</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                        <v-list-item-title>{{ $t('menu.employee') }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item link to="/absent">
                        <v-list-item-action>
                        <v-icon>mdi-account-cancel</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                        <v-list-item-title>{{ $t('menu.absent') }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item link to="/report">
                        <v-list-item-action>
                        <v-icon>mdi-chart-bar</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                        <v-list-item-title>{{ $t('menu.report') }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item link to="/user" v-if="auth.role_id == 1">
                        <v-list-item-action>
                        <v-icon>mdi-account-multiple</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                        <v-list-item-title>{{ $t('menu.user') }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item link to="/account">
                        <v-list-item-action>
                        <v-icon>mdi-account-cog</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                        <v-list-item-title>{{ $t('menu.account') }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>

                <template v-slot:append>
                    <v-btn block small depressed class="my-2 khmer-font" color="blue-grey lighten-4" @click="logout">
                        {{ $t('menu.signout') }}
                        <v-icon small>mdi-logout-variant</v-icon>
                    </v-btn>
                </template>

            </v-navigation-drawer>

        <!-- app-bar -->
            <v-app-bar color="white" app flat dense elevate-on-scroll elevation="3">
                <v-app-bar-nav-icon
                @click.stop="drawer = !drawer"
                color="blue-grey darken-3"
                ></v-app-bar-nav-icon>

                <v-toolbar-title class="grey--text text--darken-2">
                    <h4 class="khmer-font font-weight-medium">{{ $t('app.title') }}</h4>
                </v-toolbar-title>

                <v-spacer></v-spacer>

                <!-- content-class="elevation-0" -->
                <v-menu
                    offset-y
                    open-on-hover
                >
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            v-bind="attrs"
                            v-on="on"
                            depressed
                            text
                            rounded
                            class="text-lowercase font-weight-regular khmer-font"
                        >
                            <v-icon small>mdi-translate</v-icon>
                            {{ $t('languages.language') }}
                        </v-btn>
                    </template>
                    <v-list>
                        <v-list-item link>
                            <v-img
                                height="20"
                                width="20"
                                :src="'/image/englishflag.png'"
                            ></v-img>
                            <v-list-item-title @click="langChanged('english')" class="ml-1 khmer-font">
                                {{ $t('languages.english') }}
                            </v-list-item-title>
                        </v-list-item>
                        <v-list-item link>
                            <v-img
                                height="20"
                                width="20"
                                :src="'/image/cambodaiflag.png'"
                            ></v-img>

                            <v-list-item-title @click="langChanged('khmer')" class="ml-1 khmer-font">
                                {{ $t('languages.khmer') }}
                            </v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>

                <v-btn
                    class="text-capitalize khmer-font pa-1 py-1 app-date"
                    color="grey lighten-2 indigo--text"
                    depressed
                    @click="openDialog"
                >
                    <v-icon small left>mdi-calendar-month</v-icon>

                    <span v-if="formatDate(new Date()).split(',')[0] == 'Monday'">
                        <span :class="getColor(formatDate(new Date()).split(',')[0])+'--text'">{{ $t('app.monday') }},</span>
                        {{ formatDate(new Date()).split(',')[1] }}
                    </span>

                    <span v-if="formatDate(new Date()).split(',')[0] == 'Tuesday'">
                        <span :class="getColor(formatDate(new Date()).split(',')[0])+'--text'">{{ $t('app.tuesday') }},</span>
                        {{ formatDate(new Date()).split(',')[1] }}
                    </span>

                    <span v-if="formatDate(new Date()).split(',')[0] == 'Wednesday'">
                        <span :class="getColor(formatDate(new Date()).split(',')[0])+'--text'">{{ $t('app.wednesday') }},</span>
                        {{ formatDate(new Date()).split(',')[1] }}
                    </span>

                    <span v-if="formatDate(new Date()).split(',')[0] == 'Thursday'">
                        <span :class="getColor(formatDate(new Date()).split(',')[0])+'--text'">{{ $t('app.thursday') }},</span>
                        {{ formatDate(new Date()).split(',')[1] }}
                    </span>

                    <span v-if="formatDate(new Date()).split(',')[0] == 'Friday'">
                        <span :class="getColor(formatDate(new Date()).split(',')[0])+'--text'">{{ $t('app.friday') }},</span>
                        {{ formatDate(new Date()).split(',')[1] }}
                    </span>

                    <span v-if="formatDate(new Date()).split(',')[0] == 'Saturday'">
                        <span :class="getColor(formatDate(new Date()).split(',')[0])+'--text'">{{ $t('app.saturday') }},</span>
                        {{ formatDate(new Date()).split(',')[1] }}
                    </span>

                    <span v-if="formatDate(new Date()).split(',')[0] == 'Sunday'">
                        <span :class="getColor(formatDate(new Date()).split(',')[0])+'--text'">{{ $t('app.sunday') }},</span>
                        {{ formatDate(new Date()).split(',')[1] }}
                    </span>
                </v-btn>
            </v-app-bar>

        <!-- content -->
            <v-main class="mt-5 mx-2">
                <v-container fluid>
                <router-view />
                </v-container>
            </v-main>
        </v-app>

        <!-- -------dialog-------- -->
        <v-dialog
            v-model="calendarDialog"
            fullscreen
            hide-overlay
            transition="dialog-bottom-transition"
            class="calendarDialog"
            id="calendarDialog"
        >
            <v-card flat>
                <v-toolbar
                    class="khawin-background-color"
                    dark
                    extended
                    flat
                >
                <v-btn icon @click="calendarDialog = false">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
                </v-toolbar>
                <v-card
                    class="mx-auto"
                    max-width="1000"
                    style="margin-top: -64px;"
                >
                    <v-toolbar flat>
                        <v-toolbar-title class="blue-grey--text text--darken-2">
                            <div class="d-inline-flex align-center">
                                <v-icon small color="blue-grey darken-1">mdi-calendar-month</v-icon>
                                <h5 class="khmer-font font-weight-medium">{{ $t('holiday.title') }} </h5>
                                <v-chip
                                    class="ml-1 pa-1 font-weight-bold"
                                    label
                                    text-color="light-blue darken-3"
                                    @click="chooseHolidayYear"
                                >
                                    {{ new Date().getFullYear() }}
                                </v-chip>
                            </div>
                        </v-toolbar-title>
                        <v-spacer></v-spacer>

                        <v-btn depressed class="khawin-background-color khmer-font" small dark @click="openDialogInsertForm()">
                            <v-icon left>mdi-plus-circle</v-icon>
                            {{ $t('holiday.addHoliday') }}
                        </v-btn>
                    </v-toolbar>
                    <v-divider></v-divider>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" sm="12" md="8">
                                <v-data-table
                                    class="khmer-font"
                                    :headers="headers"
                                    :items="holidayData"
                                    :items-per-page="-1"
                                >
                                    <template v-slot:[`item.id`]="item">
                                        {{ item.index + 1 }}
                                    </template>

                                    <template v-slot:[`item.day`]="{ item }">
                                        <v-chip
                                            v-if="formatCompareDate(new Date()) > item.date"
                                            :text-color="getColor(item.day)"
                                            class="text-capitalize absent-day-chip text-decoration-line-through font-weight-medium"
                                            small
                                        >
                                            <span v-if="item.day == 'Monday'">{{ $t('absent.monday') }}</span>
                                            <span v-if="item.day == 'Tuesday'">{{ $t('absent.tuesday') }}</span>
                                            <span v-if="item.day == 'Wednesday'">{{ $t('absent.wednesday') }}</span>
                                            <span v-if="item.day == 'Thursday'">{{ $t('absent.thursday') }}</span>
                                            <span v-if="item.day == 'Friday'">{{ $t('absent.friday') }}</span>
                                            <span v-if="item.day == 'Saturday'">{{ $t('absent.saturday') }}</span>
                                            <span v-if="item.day == 'Sunday'">{{ $t('absent.sunday') }}</span>
                                        </v-chip>

                                        <v-chip
                                            v-else
                                            dark
                                            :color="getColor(item.day)"
                                            class="text-capitalize absent-day-chip"
                                            small
                                        >
                                            <span v-if="item.day == 'Monday'">{{ $t('absent.monday') }}</span>
                                            <span v-if="item.day == 'Tuesday'">{{ $t('absent.tuesday') }}</span>
                                            <span v-if="item.day == 'Wednesday'">{{ $t('absent.wednesday') }}</span>
                                            <span v-if="item.day == 'Thursday'">{{ $t('absent.thursday') }}</span>
                                            <span v-if="item.day == 'Friday'">{{ $t('absent.friday') }}</span>
                                            <span v-if="item.day == 'Saturday'">{{ $t('absent.saturday') }}</span>
                                            <span v-if="item.day == 'Sunday'">{{ $t('absent.sunday') }}</span>
                                        </v-chip>

                                    </template>

                                    <template v-slot:[`item.date`]="{ item }">
                                        <v-chip
                                            class="pa-1 holiday-dates font-weight-bold"
                                            small
                                            color="red lighten-5"
                                            text-color="red darken-3"
                                            label
                                        >
                                            <v-avatar left class="mr-0">
                                            <v-icon small>mdi-calendar-month</v-icon>
                                            </v-avatar>

                                            <span v-if="formatCompareDate(new Date()) > item.date"
                                                class="text-decoration-line-through"
                                            >
                                                {{ formatHolidayDate(item.date) }}
                                            </span>
                                            <span v-else>
                                                {{ formatHolidayDate(item.date) }}
                                            </span>

                                        </v-chip>
                                    </template>

                                    <template v-slot:[`item.holiday`]="{ item }">
                                        <span v-if="formatCompareDate(new Date()) > item.date"
                                            class="text-decoration-line-through"
                                        >
                                            {{ item.holiday }}
                                        </span>
                                        <span v-else>
                                            {{ item.holiday }}
                                        </span>
                                    </template>

                                    <template v-slot:[`item.actions`]="{ item }">
                                        <v-icon small class="mr-2" @click="editHoliday(item)">mdi-pencil</v-icon>
                                        <v-icon small class="mr-2" @click="deleteHoliday(item.id)">mdi-delete</v-icon>
                                    </template>
                                </v-data-table>
                            </v-col>
                            <v-col cols="12" sm="12" md="4">
                                <v-date-picker
                                    v-model="holidayDates"
                                    multiple
                                    readonly
                                    color="red"
                                ></v-date-picker>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-card>
        </v-dialog>

        <!-- --------Absent-Insert-Form------ -->
        <v-dialog v-model="holidayForm" width="500" persistent overlay-opacity="0">
            <v-card>
                <v-toolbar dense flat color="lighten-1" class="user-form-dialog khawin-background-color">
                    <span v-if="editMode === false" class="white--text">
                        <v-icon left color="white">mdi-calendar-month</v-icon>
                        <!-- {{ formTitle }} -->
                        {{ $t('holiday.frmtitleAdd') }}
                    </span>
                    <span v-else class="white--text">
                        <v-icon left dark>mdi-calendar-month</v-icon> {{ $t('holiday.frmtitleEdit') }}
                    </span>
                </v-toolbar>

                <form @submit.prevent="editMode ? updateHoliday() : createHoliday()">
                    <v-card-text>
                        <v-menu
                            v-model="holidayDateChoose"
                            :close-on-content-click="false"
                            max-width="290"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    class="khmer-font"
                                    :value="computedDateFormattedMomentjs"
                                    v-bind:label="$t('holiday.txtHolidayDate')"
                                    color="cyan darken-1"
                                    prepend-inner-icon="mdi-calendar"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                    outlined
                                    :error-messages="errorsMessage.date"
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                v-model="form.date"
                                @input="holidayDateChoose = false"
                            ></v-date-picker>
                        </v-menu>

                        <v-textarea
                            v-model="form.holiday"
                            outlined
                            color="cyan darken-1"
                            class="khmer-font"
                            v-bind:label="$t('holiday.txtHolidayDetail')"
                            rows="3"
                            prepend-inner-icon="mdi-calendar-text"
                            :error-messages="errorsMessage.holiday"
                        ></v-textarea>
                    </v-card-text>

                    <v-card-actions class="card-action">
                        <v-spacer></v-spacer>
                        <v-btn small color="grey lighten-2" depressed @click="closeDialog">
                            {{ $t('holiday.btnCancel') }}
                        </v-btn>
                        <v-btn class="khawin-background-color" dark small depressed type="submit" :loading="btnSaveLoading">
                            {{ $t('holiday.btnSave') }}
                        </v-btn>
                    </v-card-actions>
                </form>
            </v-card>
        </v-dialog>

        <!-- ---------------Snacbar--------------- -->
        <v-snackbar v-model="snackbar" color="indigo lighten-1" dark>
            {{ alertSnackbarMsg }}
            <template v-slot:action="{ attrs }">
                <v-btn dark text v-bind="attrs" @click="snackbar = false" small>
                close
                </v-btn>
            </template>
        </v-snackbar>

         <!-- ----------dialogDelete------------ -->
        <v-dialog v-model="dialogDelete" max-width="330px">
            <v-card>
                <div class="text-center">
                    <v-sheet class="px-7 pt-7 pb-4 mx-auto text-center d-inline-block">
                        <v-icon class="text-center pb-3" x-large color="red lighten-2"
                        >mdi-alert</v-icon>
                        <div class="grey--text text--darken-3 text-body-2 mb-4">
                            Are you sure ?
                        </div>

                        <v-btn
                            :disabled="btnLoading"
                            class="ma-1"
                            depressed
                            small
                            @click="dialogDelete = false"
                        >
                        Cancel
                        </v-btn>

                        <v-btn
                            :loading="btnLoading"
                            class="ma-1"
                            dark
                            color="red"
                            small
                            depressed
                            @click="submitDelete"
                        >
                            Delete
                        </v-btn>
                    </v-sheet>
                </div>
            </v-card>
        </v-dialog>
    </div>
</template>

<style scoped>
.v-text-field--outlined >>> fieldset {
  border-color: rgba(177, 177, 177, 0.644);
}
</style>

<script>
    import AOS from "aos";
    import "aos/dist/aos.css";
    import moment from "moment";
    AOS.init();
    export default {
    data() {
        return {
            drawer: null,
            btnLoading: false,
            cardLoading: false,
            showPassword: false,
            email: "",
            password: "",
            errorsMessage: {
                email: "",
                password: "",
            },
            authData: "",
            authName: "",

            // ========Calendar==========
            editMode: false,
            holidayForm: false,
            btnSaveLoading: false,
            calendarDialog: false,
            holidayDateChoose: false,
            snackbar: false,
            alertSnackbarMsg: "",
            dialogDelete: false,
            form: new Form({
                id: "",
                date: "",
                holiday: "",
            }),
            holidayData: [],
            holidayDates: [],
            holidayDatesCount: "",

            desserts: [
            {
                calories: 159,
                fat: 6.0,
                carbs: 24,
                protein: 4.0,
            },
            {
                calories: 237,
                fat: 9.0,
                carbs: 37,
                protein: 4.3,
            },
            {
                calories: 262,
                fat: 16.0,
                carbs: 23,
                protein: 6.0,
            },
            {
                calories: 305,
                fat: 3.7,
                carbs: 67,
                protein: 4.3,
            },
            {
                calories: 356,
                fat: 16.0,
                carbs: 49,
                protein: 3.9,
            },
            {
                calories: 375,
                fat: 0.0,
                carbs: 94,
                protein: 0.0,
            },
            {
                calories: 392,
                fat: 0.2,
                carbs: 98,
                protein: 0,
            },
            {
                calories: 408,
                fat: 3.2,
                carbs: 87,
                protein: 6.5,
            },
            {
                calories: 452,
                fat: 25.0,
                carbs: 51,
                protein: 4.9,
            },
            {
                calories: 518,
                fat: 26.0,
                carbs: 65,
                protein: 7,
            },
            ],
        };
    },

        computed: {
            loggedIn() {
                return this.$store.getters.loggedIn;
            },

            auth() {
                return this.$store.state.auth;
            },

            formTitle() {
                return this.editMode === false ? "Add Holiday" : "Edit Holiday";
            },

            computedDateFormattedMomentjs() {
                return this.form.date
                    ? moment(this.form.date).format("dddd, DD/ MM/ YYYY")
                    : "";
            },

            headers(){
                return [
                    {
                        text: '#',
                        align: 'start',
                        value: 'id'
                    },
                    { text: this.$t('holiday.tbDay'), value: 'day' },
                    { text: this.$t('holiday.tbDate'), value: 'date' },
                    { text: this.$t('holiday.tbHoliday'), value: 'holiday' },
                    { text: this.$t('holiday.tbAction'), sortable: false, value: "actions" },
                ]
            }
        },

        mounted() {
            if(localStorage.Lang!=null) this.$i18n.locale=localStorage.Lang;
        },

        methods: {

            langChanged(lang){
                this.$i18n.locale = lang;
                localStorage.Lang = lang
            },

            getColor(day) {
                if (day == "Monday") return "orange";
                else if (day == "Tuesday") return "purple";
                else if (day == "Wednesday") return "light-green";
                else if (day == "Thursday") return "green";
                else if (day == "Friday") return "blue";
                else if (day == "Saturday") return "pink";
                else if (day == "Sunday") return "red";
            },

            formatDate(value) {
                return moment(value).format("dddd, DD/MM/YYYY");
            },

            chooseHolidayYear(){
                console.log('hello')
            },

            login() {
                if (this.email.length == 0 || this.password.length == 0) {
                    this.errorsMessage.email = "The email field is required.";
                    this.errorsMessage.password = "The password field is required.";
                } else {
                    this.btnLoading = true;
                    this.cardLoading = true;

                    setTimeout(
                    () => ((this.btnLoading = false), (this.cardLoading = false)),
                        3000
                    );
                    this.$store.dispatch("token", {
                        email: this.email,
                        password: this.password,
                    });
                }
            },

            logout() {
            this.email = "";
            this.password = "";
            this.$store.dispatch("destroyToken").then(() => {
                this.$router.push({ name: "login" });
            });
            },

            // =====================HOLIDAY=======================
            formatHolidayDate(value) {
                return moment(value).format("DD/MM/YYYY");
            },

            formatCompareDate(value) {
                return moment(value).format("YYYY-MM-DD");
            },

            getColor(day) {
                if (day == "Monday") return "orange darken-2";
                else if (day == "Tuesday") return "purple";
                else if (day == "Wednesday") return "light-green";
                else if (day == "Thursday") return "green";
                else if (day == "Friday") return "blue";
                else if (day == "Saturday") return "pink darken-2";
                else if (day == "Sunday") return "red";
            },

            getDataHoliday(){
                var token = localStorage.getItem("access_token");
                if(token){
                    console.log('logged in');
                }
            },

            ReadHoliday() {
                axios
                .get("http://127.0.0.1:8000/api/read-holiday", {
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem("access_token"),
                    },
                })
                .then((response) => {
                    this.holidayData = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
            },

            ReadHolidayDates() {
                axios
                .get("http://127.0.0.1:8000/api/read-holiday-date", {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("access_token"),
                },
                })
                .then((response) => {
                    this.holidayDates = response.data;
                    this.holidayDatesCount.length;
                })
                .catch((error) => {
                    console.log(error);
                });
            },

            openDialog(){
                this.ReadHoliday();
                this.ReadHolidayDates();
                this.calendarDialog = true;
            },

            openDialogInsertForm() {
                this.holidayForm = true;
            },

            closeDialog() {
                this.editMode = false;
                this.holidayForm = false;
                this.form.date = "";
                this.form.holiday = "";
            },

            createHoliday() {
                this.btnSaveLoading = true;
                this.tableLoading = true;
                this.form
                    .post("api/create-holiday", {
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem("access_token"),
                    },
                    })
                    .then((response) => {
                        this.ReadHoliday();
                        this.ReadHolidayDates();
                        this.closeDialog();
                        this.alertSnackbarMsg = response.data.message;
                        this.snackbar = true;
                        this.btnSaveLoading = false;
                        this.tableLoading = false;
                    })
                    .catch((errors) => {
                        this.errorsMessage = errors.response.data.errors;
                        this.btnSaveLoading = false;
                        this.tableLoading = false;
                    });
            },

            editHoliday(holiday) {
                this.editMode = true;
                this.form.id = holiday.id;
                this.form.day = holiday.day;
                this.form.date = holiday.date;
                this.form.holiday = holiday.holiday;
                this.holidayForm = true;
            },

            async updateHoliday() {
                this.btnSaveLoading = true;
                this.tableLoading = true;
                await new Promise((resolve) => setTimeout(resolve, 1000));
                this.form
                    .post("/api/update-holiday/" + this.form.id, {
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem("access_token"),
                    },
                    })
                    .then((response) => {
                        this.ReadHoliday();
                        this.ReadHolidayDates();
                        this.closeDialog();
                        this.alertSnackbarMsg = response.data.message;
                        this.snackbar = true;
                        this.btnSaveLoading = false;
                        this.tableLoading = false;
                    })
                    .catch((errors) => {
                        this.errorsMessage = errors.response.data.errors;
                        this.btnSaveLoading = false;
                        this.tableLoading = false;
                    });
            },

            deleteHoliday(holiday_id) {
                this.form.id = holiday_id;
                this.dialogDelete = true;
            },

            async submitDelete() {
                this.btnLoading = true;
                this.tableLoading = true;
                await new Promise((resolve) => setTimeout(resolve, 1000));
                axios
                    .delete("/api/delete-holiday/" + this.form.id, {
                    headers: {
                        Authorization: "Bearer " + localStorage.getItem("access_token"),
                    },
                    })
                    .then((response) => {
                        this.ReadHoliday();
                        this.ReadHolidayDates();
                        this.dialogDelete = false;
                        this.alertSnackbarMsg = response.data.message;
                        this.snackbar = true;
                        this.btnLoading = false;
                        this.tableLoading = false;
                    })
                    .catch((error) => {
                        this.btnLoading = false;
                        this.tableLoading = false;
                    });
            },

        },
    };
</script>
