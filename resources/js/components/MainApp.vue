<template>
  <div>
    <v-app v-if="!loggedIn">
      <v-container class="login-container" fill-height fluid>
        <v-row align="center" justify="center">
          <v-col cols="12" md="6">
            <v-card class="pa-5 card-background">
              <v-card height="400" class="mt-3">
                <v-progress-linear
                  absolute
                  top
                  color="blue"
                  :active="cardLoading"
                  :indeterminate="cardLoading"
                ></v-progress-linear>

                <v-row>
                  <v-col
                    cols="12"
                    sm="5"
                    class="d-flex justify-center align-center"
                    data-aos="fade-right"
                  >
                    <v-img
                      max-height="300"
                      max-width="100%"
                      :src="'/image/41291-human-resources-approval-animation.gif'"
                    ></v-img>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="7"
                    class="pa-0"
                    data-aos="fade-up"
                    data-aos-anchor-placement="top-bottom"
                  >
                    <v-card elevation="0" class="ma-5">
                      <span class="title blue--text">ABSENT MANAGERMENT</span>
                      <v-card-text class="mt-2 pb-0">
                        <p>Sign in with your email and password:</p>

                        <v-alert
                          v-if="this.$store.state.credentials"
                          data-aos="zoom-in"
                          text
                          prominent
                          type="error"
                          icon="mdi-alert-circle"
                          class="pa-2"
                        >
                          <h5>{{ this.$store.state.credentials }}</h5>
                        </v-alert>

                        <v-text-field
                          v-model="email"
                          label="Email"
                          type="text"
                          outlined
                          prepend-inner-icon="mdi-email"
                          :error-messages="errorsMessage.email"
                        ></v-text-field>

                        <v-text-field
                          v-model="password"
                          :append-icon="
                            showPassword ? 'mdi-eye' : 'mdi-eye-off'
                          "
                          :type="showPassword ? 'text' : 'password'"
                          label="Password"
                          prepend-inner-icon="mdi-lock"
                          outlined
                          @click:append="showPassword = !showPassword"
                          :error-messages="errorsMessage.password"
                        ></v-text-field>
                      </v-card-text>
                      <v-card-actions class="ml-3">
                        <v-btn
                          color="info"
                          depressed
                          :loading="btnLoading"
                          @click="login"
                        >
                          <v-icon left>mdi-lock</v-icon>
                          Login
                        </v-btn>
                        <v-spacer></v-spacer>
                        <p class="subtitle-2 blue--text">Forgot password?</p>
                      </v-card-actions>
                    </v-card>
                  </v-col>
                </v-row>
              </v-card>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-app>

    <v-app v-else id="main-app">
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

          <v-list-item link to="/employee">
            <v-list-item-action>
              <v-icon>mdi-account-tie</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>Employees</v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-item link to="/user">
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

        <v-toolbar-title class="indigo--text font-weight-bold">
          Absent Managerment
        </v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn text icon>
          <v-icon color="grey darken-1">mdi-bell</v-icon>
        </v-btn>

        <v-btn text color="grey darken-1" @click="logout">
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

  mounted() {
    if (JSON.parse(localStorage.getItem("auth"))) {
      this.authData = JSON.parse(localStorage.getItem("auth"));
      if (this.authData) {
        this.authName = this.authData.name
          .split(" ")
          .map((x) => x[0].toUpperCase())
          .join("");
      }
    }
  },

  methods: {
    login() {
      if (this.email.length == 0 || this.password.length == 0) {
        this.errorsMessage.email = "The email field is required.";
        this.errorsMessage.password = "The password field is required.";
      } else {
        this.btnLoading = true;
        this.cardLoading = true;
        this.$store
          .dispatch("token", {
            email: this.email,
            password: this.password,
          })
          .then((response) => {
            this.btnLoading = false;
            this.cardLoading = false;

            this.authData = response.data.user;
            this.authName = this.authData.name
              .split(" ")
              .map((x) => x[0].toUpperCase())
              .join("");
          });
      }
    },

    logout() {
      this.$store.dispatch("destroyToken");
      //   window.location.reload();
    },
  },
};
</script>
