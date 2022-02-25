<template>
  <div id="account">
    <v-tabs v-model="tab">
      <v-tabs-slider color="indigo"></v-tabs-slider>
      <v-tab key="username" class="font-weight-bold text-capitalize"
        ><v-icon>mdi-account</v-icon> Profile</v-tab
      >
      <v-tab key="password" class="font-weight-bold text-capitalize"
        ><v-icon>mdi-lock</v-icon> Password</v-tab
      >
    </v-tabs>

    <v-tabs-items v-model="tab">
      <v-tab-item key="account">
        <v-card
          id="account-setting"
          class="mx-auto ma-6"
          max-width="350"
          outlined
        >
          <v-progress-linear
            :active="loading"
            :indeterminate="loading"
            absolute
            top
            color="indigo"
          ></v-progress-linear>

          <v-form
            @submit.prevent="UpdateProfile()"
            enctype="multipart/form-data"
          >
            <div class="d-flex justify-center mt-6 profile-img">
              <div>
                <v-avatar size="70" class="ma-1">
                  <v-img
                    v-if="preview_profile"
                    :src="preview_profile"
                    class="img-fluid rounded-sm"
                  ></v-img>
                  <v-img
                    v-else-if="authData.profile == 'default.png'"
                    :src="'/image/default.png'"
                  />
                  <v-img v-else :src="'/profiles/' + authData.profile" />
                </v-avatar>
                <v-file-input
                  v-model="form.profile"
                  hide-input
                  hide-details
                  @change="onFileChange"
                  accept="image/png, image/jpeg, image/bmp"
                  prepend-icon="mdi-camera"
                ></v-file-input>
              </div>
            </div>

            <v-card-text>
              <v-text-field
                v-model="form.name"
                label="User Name"
                outlined
                prepend-inner-icon="mdi-account"
                :error-messages="errorsMessage.name"
              ></v-text-field>

              <v-text-field
                v-model="form.email"
                label="Email"
                outlined
                prepend-inner-icon="mdi-email"
                :error-messages="errorsMessage.email"
              ></v-text-field>

              <v-btn
                depressed
                small
                block
                color="indigo"
                type="submit"
                :loading="btnLoading"
                dark
                >save</v-btn
              >
            </v-card-text>
          </v-form>
        </v-card>
      </v-tab-item>

      <v-tab-item key="password">
        <v-card class="mx-auto ma-6" max-width="350" outlined>
          <v-form
            @submit.prevent="UpdateProfile()"
            enctype="multipart/form-data"
          >
            <v-card-text>
              <v-text-field
                :append-icon="password ? 'mdi-eye' : 'mdi-eye-off'"
                :type="password ? 'text' : 'password'"
                label="Password"
                @click:append="password = !password"
              ></v-text-field>

              <v-text-field
                :append-icon="confirmPassword ? 'mdi-eye' : 'mdi-eye-off'"
                :type="confirmPassword ? 'text' : 'password'"
                label="Confirm Password"
                @click:append="confirmPassword = !confirmPassword"
              ></v-text-field>

              <v-text-field
                :append-icon="newPassword ? 'mdi-eye' : 'mdi-eye-off'"
                :type="newPassword ? 'text' : 'password'"
                label="New Password "
                @click:append="newPassword = !newPassword"
              ></v-text-field>

              <p>Forgot password ?</p>

              <v-btn
                depressed
                small
                block
                color="indigo"
                type="submit"
                :loading="btnLoading"
                dark
                >save</v-btn
              >
            </v-card-text>
          </v-form>
        </v-card>
      </v-tab-item>
    </v-tabs-items>

    <!-- ---------------Snacbar--------------- -->
    <v-snackbar v-model="snackbar" color="indigo lighten-1" dark top right>
      {{ alertSnackbarMsg }}
      <template v-slot:action="{ attrs }">
        <v-btn dark text v-bind="attrs" @click="snackbar = false" small>
          close
        </v-btn>
      </template>
    </v-snackbar>
  </div>
</template>

<script>
export default {
  data() {
    return {
      tab: null,
      snackbar: false,
      alertSnackbarMsg: "",
      loading: false,
      btnLoading: false,
      password: false,
      confirmPassword: false,
      newPassword: false,
      preview_profile: null,
      errorsMessage: "",

      form: new Form({
        name: "",
        email: "",
        profile: null,
      }),
    };
  },

  computed: {
    authData() {
      return JSON.parse(localStorage.getItem("auth"));
    },
  },

  mounted() {
    this.form.name = this.authData.name;
    this.form.email = this.authData.email;
  },

  methods: {
    // ---------------------------------
    createImage(file) {
      const reader = new FileReader();

      reader.onload = (e) => {
        this.preview_profile = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    onFileChange(file) {
      if (!file) {
        return;
      }
      this.createImage(file);
    },
    UpdateProfile() {
      this.btnLoading = true;
      this.loading = true;
      setTimeout(
        () =>
          this.$store
            .dispatch("updateProfifle", {
              id: this.authData.id,
              name: this.form.name,
              email: this.form.email,
              profile: this.preview_profile,
            })
            .then((response) => {
              if (response.status == 200) {
                this.btnLoading = false;
                this.loading = false;
                this.alertSnackbarMsg = response.data.message;
                this.snackbar = true;

                if (this.authData.email !== response.data.user.email) {
                  this.alertSnackbarMsg =
                    "Email has been update please login again.";
                  this.snackbar = true;
                  setTimeout(() => this.$store.dispatch("destroyToken"), 3000);
                }
              }
            })
            .catch((errors) => {
              this.errorsMessage = errors.response.data.errors;
              this.btnLoading = false;
              this.loading = false;
            }),
        3000
      );
    },
  },
};
</script>
