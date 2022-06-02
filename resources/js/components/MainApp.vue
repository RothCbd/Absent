<template>
  <div>
    <v-app v-if="!loggedIn">
      <v-container class="login-container" fill-height fluid>
        <router-view />
      </v-container>
    </v-app>

    <v-app v-if="loggedIn" id="main-app">
      <v-navigation-drawer color="grey lighten-5" app v-model="drawer">
        <v-card flat color="indigo" class="menu-card">
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
                      >{{
                        auth.name
                          .split(" ")
                          .map((x) => x[0].toUpperCase())
                          .join("")
                      }}</span
                    >

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
        <v-list dense class="menu-icon">
          <v-list-item link to="/">
            <v-list-item-action>
              <v-icon>mdi-view-dashboard</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>Dashboard</v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-item link to="/employee">
            <v-list-item-action>
              <v-icon>mdi-account-tie</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>Employees</v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-item link to="/absent">
            <v-list-item-action>
              <v-icon>mdi-account-cancel</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>Absent</v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-item link to="/report">
            <v-list-item-action>
              <v-icon>mdi-chart-bar</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>Report</v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-item link to="/user" v-if="auth.role_id == 1">
            <v-list-item-action>
              <v-icon>mdi-account-multiple</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>Users</v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-item link to="/account">
            <v-list-item-action>
              <v-icon>mdi-account-cog</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>Account</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-navigation-drawer>

      <!-- app-bar -->
      <v-app-bar color="white" app flat dense elevate-on-scroll elevation="3">
        <v-app-bar-nav-icon
          @click.stop="drawer = !drawer"
          color="blue-grey darken-3"
        ></v-app-bar-nav-icon>

        <v-toolbar-title class="grey--text text--darken-2 font-weight-medium">
          <small>Absence Management</small>
        </v-toolbar-title>

        <v-spacer></v-spacer>

        <h4 class="mr-6 grey--text text--darken-1 mt-1 font-weight-medium d-none d-sm-flex">
          <v-chip label outlined color="grey--text text--darken-2" small>
            {{ formatDate(new Date()) }}
          </v-chip>
        </h4>

        <v-btn text color="grey darken-1" @click="logout" small>
          sign out
          <v-icon>mdi-login-variant</v-icon>
        </v-btn>
      </v-app-bar>

      <!-- content -->
      <v-main class="mt-5 mx-2">
        <v-container fluid>
          <router-view />
        </v-container>
      </v-main>
    </v-app>
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
    };
  },

  computed: {
    loggedIn() {
      return this.$store.getters.loggedIn;
    },

    auth() {
      return this.$store.state.auth;
    },
  },

  methods: {
    formatDate(value) {
      return moment(value).format("dddd, DD-MM-YYYY");
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
  },
};
</script>
