<template>
  <!-- <div id="login">
    <v-container>
      <v-layout wrap>
        <v-flex sm12 md6 offset-md3>
          <v-card elevation="4" light tag="section">
            <v-card-title class="grey lighten-3">
              <v-layout align-center justify-space-between>
                <h4 class="primary--text">ABSENT MANAGERMENT</h4>
              </v-layout>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
              <p>Sign in with your email and password:</p>
              <v-alert
                text
                prominent
                type="error"
                icon="mdi-alert-circle"
                class="pa-2"
              >
                <h5>{{ this.$store.state.credentials }}</h5>
              </v-alert>
              <v-form>
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
                  :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                  :type="showPassword ? 'text' : 'password'"
                  label="Password"
                  prepend-inner-icon="mdi-lock"
                  outlined
                  @click:append="showPassword = !showPassword"
                  :error-messages="errorsMessage.password"
                ></v-text-field>
              </v-form>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
              <v-btn color="info" text> Forgot password? </v-btn>
              <v-spacer></v-spacer>
              <v-btn color="info" :loading="btnLoading" @click="login">
                <v-icon left>mdi-lock</v-icon>
                Login
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-flex>
        <v-flex sm md6 offset-md3>
          <v-layout align-center justify-space-between>
            <p class="caption my-3">
              <a href="#">Privacy Policy</a>
              |
              <a href="#">Terms of Service</a>
            </p>
            <p class="caption my-3">Powered by <a href="#">Khawin</a></p>
          </v-layout>
        </v-flex>
      </v-layout>
    </v-container>
  </div> -->
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
                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
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
                  <router-link link to="forgotPassword">
                    <p class="subtitle-2 blue--text">Forgot password?</p>
                  </router-link>
                </v-card-actions>
              </v-card>
            </v-col>
          </v-row>
        </v-card>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: "login",

  data() {
    return {
      cardLoading: false,
      btnLoading: false,
      showPassword: false,
      email: "",
      password: "",
      errorsMessage: {
        email: "",
        password: "",
      },
    };
  },

  methods: {
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
        this.$store
          .dispatch("token", {
            email: this.email,
            password: this.password,
          })
          .then(() => {
            this.$router.push({ name: "dashboard" });
          });
      }
    },
  },
};
</script>
