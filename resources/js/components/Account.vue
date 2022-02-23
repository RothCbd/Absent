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
          <v-form
            @submit.prevent="UpdateProfile()"
            enctype="multipart/form-data"
          >
            <div class="d-flex justify-center mt-6 profile-img">
              <div>
                <v-avatar size="70" class="ma-1">
                  <v-img :src="'/image/default.png'" />
                </v-avatar>
                <v-file-input
                  hide-input
                  hide-details
                  accept="image/png, image/jpeg, image/bmp"
                  prepend-icon="mdi-camera"
                ></v-file-input>
              </div>
            </div>

            <v-card-text>
              <v-text-field
                label="User Name"
                outlined
                prepend-inner-icon="mdi-account"
              ></v-text-field>

              <v-text-field
                v-model="user.email"
                label="Email"
                outlined
                prepend-inner-icon="mdi-email"
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
  </div>
</template>

<script>
export default {
  data() {
    return {
      tab: null,
      btnLoading: false,
      password: false,
      confirmPassword: false,
      newPassword: false,

      user: {
        email: "",
        password: "",
      },
    };
  },

  methods: {
    UpdateProfile() {
      //   this.$store.commit("setUser", this.user.email);
    },
  },
};
</script>
