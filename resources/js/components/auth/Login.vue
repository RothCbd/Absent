<template>
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
              sm="12"
              md="5"
              class="d-flex justify-center align-center d-sm-none d-md-flex login-logo"
              data-aos="fade-right"

            >
              <v-img
                class="login-logo"
                max-height="300"
                max-width="100%"
                :src="'/image/41291-human-resources-approval-animation.gif'"
              ></v-img>
            </v-col>
            <v-col
              cols="12"
              sm="12"
              md="7"
              class="pa-0 frm-login"
              data-aos="fade-up"
              data-aos-anchor-placement="top-bottom"
            >
              <v-card elevation="0" class="ma-5">
                <span class="title blue--text khmer-font">{{ $t('login.title') }}</span>
                <v-card-text class="mt-2 pb-0">
                  <p class="khmer-font subtitle-1">{{ $t('login.description') }}</p>

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
                    class="khmer-font"
                    v-bind:label="$t('login.email')"
                    type="text"
                    outlined
                    prepend-inner-icon="mdi-email"
                    :error-messages="errorsMessage.email"
                  ></v-text-field>

                  <v-text-field
                    v-model="password"
                    class="khmer-font"
                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    :type="showPassword ? 'text' : 'password'"
                    v-bind:label="$t('login.password')"
                    prepend-inner-icon="mdi-lock"
                    outlined
                    @click:append="showPassword = !showPassword"
                    :error-messages="errorsMessage.password"
                  ></v-text-field>
                </v-card-text>
                <v-card-actions class="ml-3">
                  <v-btn
                    class="khmer-font"
                    color="info"
                    depressed
                    :loading="btnLoading"
                    @click="login"
                  >
                    <v-icon left>mdi-lock</v-icon>
                    {{ $t('login.login') }}
                  </v-btn>
                  <v-spacer></v-spacer>
                  <div class="d-flex flex-column justify-end align-end">
                    <router-link link to="forgotPassword">
                        <p class="subtitle-2 blue--text">{{ $t('login.forgotPass') }}</p>
                    </router-link>
                    <div class="d-flex flex-row">
                            <v-btn
                                icon
                                @click="langChanged('khmer')"
                            >
                                <v-img
                                    max-height="25"
                                    max-width="25"
                                    :src="'/image/Flag_of_Cambodia.svg'"
                                ></v-img>
                            </v-btn>

                            <v-btn
                                icon
                                @click="langChanged('english')"
                            >
                                <v-img
                                    max-height="25"
                                    max-width="25"
                                    :src="'/image/Flag_of_Great_Britain_(1707–1800).svg.png'"
                                ></v-img>
                            </v-btn>
                        </div>
                  </div>

                   <!-- =============== -->
                    <!-- {{ languagesName == 'khmer' ? $t('login.langKhmer') : $t('login.langEnglish') }} -->
                    <!-- <v-menu
                        offset-y
                        open-on-hover
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                v-bind="attrs"
                                v-on="on"
                                icon
                                class="text-lowercase font-weight-regular khmer-font language-login"
                            >
                                <v-img
                                    v-if="languagesName == 'khmer'"
                                    height="20"
                                    width="30"
                                    :src="'/image/Flag_of_Cambodia.svg'"
                                ></v-img>
                                <v-img
                                    v-else
                                    height="20"
                                    width="30"
                                    :src="'/image/Flag_of_Great_Britain_(1707–1800).svg.png'"
                                ></v-img>
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
                    </v-menu> -->
                    <!-- =============== -->

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
        languagesName: '',
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

  mounted(){
    this.languagesName = localStorage.getItem('Lang');
  },

  methods: {

    langChanged(lang){
        this.$i18n.locale = lang;
        localStorage.Lang = lang;

        this.languagesName = lang;
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
