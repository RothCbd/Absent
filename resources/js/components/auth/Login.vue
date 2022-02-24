<template>
  <div id="login">
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
  </div>
</template>

<script>
export default {
  name: "login",

  data() {
    return {
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
        this.$store
          .dispatch("token", {
            email: this.email,
            password: this.password,
          })
          .then((response) => {
            // console.log(response);
            this.$router.push({ name: "dashboard" });
          });
      }
    },
  },
};
</script>
