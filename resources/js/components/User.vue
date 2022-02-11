<template>
  <div id="user">
    <div>
      <v-row>
        <v-col cols="sm-8">
          <h5 class="grey--text text--darken-2">
            <v-icon left color="grey darken-2">mdi-account-multiple</v-icon>User
            List
            <v-chip color="grey lighten-2 grey--text text--darken-3">{{
              userCount
            }}</v-chip>
          </h5>
        </v-col>
        <v-col cols="sm-4" class="text-right">
          <v-btn
            small
            color="indigo"
            class="add-user white--text"
            @click="openDialog"
            ><v-icon left>mdi-plus</v-icon> Add User</v-btn
          >
        </v-col>
      </v-row>

      <!-- -------table---- -->
      <v-card class="mx-auto table-card">
        <v-data-table
          :headers="headers"
          :items="userData"
          :search="search"
          :loading="tableLoading"
          loading-text="Loading users data"
        >
          <template v-slot:[`item.id`]="item">
            {{ item.index + 1 }}
          </template>

          <template v-slot:[`item.name`]="{ item }">
            <v-avatar
              size="37"
              class="m-1"
              left
              v-if="item.profile == 'default.png'"
            >
              <v-img :src="'/image/default.png'" />
            </v-avatar>
            <v-avatar size="37" class="m-1" left v-else>
              <v-img :src="'/profiles/' + item.profile" />
            </v-avatar>

            <small
              class="
                font-weight-medium
                blue-grey--text
                text--darken-3 text-capitalize
              "
            >
              {{ item.name }}
            </small>
          </template>

          <template v-slot:[`item.role`]="{ item }">
            <v-chip
              v-if="item.role == 'admin'"
              small
              label
              class="text-capitalize"
              color="indigo"
              dark
              >{{ item.role }}
            </v-chip>

            <v-chip
              v-else
              small
              label
              class="text-capitalize"
              color="orange"
              dark
              >{{ item.role }}
            </v-chip>
          </template>

          <template v-slot:[`item.actions`]="{ item }">
            <v-icon x-small class="mr-2">mdi-pencil</v-icon>
            <v-icon x-small class="mr-2">mdi-delete</v-icon>
          </template>
        </v-data-table>
      </v-card>

      <!-- --------User-Insert-Form------ -->
      <v-dialog v-model="userForm" width="550" persistent overlay-opacity="0">
        <v-card>
          <v-toolbar dense flat color="indigo lighten-1">
            <span v-if="editMode === false" class="white--text">
              <v-icon left color="white">mdi-account-plus</v-icon>
              {{ formTitle }}
            </span>
            <span v-else
              ><v-icon left>mdi-file-edit-outline</v-icon>{{ formTitle }}</span
            >
          </v-toolbar>

          <form
            @submit.prevent="editMode ? updatePost() : createPost()"
            enctype="multipart/form-data"
            class="user-form"
          >
            <v-card-text>
              <v-row>
                <v-col sm="8">
                  <v-select
                    v-model="form.role_id"
                    :items="role"
                    item-value="value"
                    label="Role"
                    dense
                    prepend-icon="mdi-account-star"
                    :error-messages="errorsMessage.role_id"
                  >
                  </v-select>

                  <v-text-field
                    v-model="form.name"
                    label="Name"
                    prepend-icon="mdi-account-edit"
                    :error-messages="errorsMessage.name"
                  ></v-text-field>

                  <v-text-field
                    v-model="form.email"
                    label="Email"
                    prepend-icon="mdi-email"
                    :error-messages="errorsMessage.email"
                  ></v-text-field>

                  <!-- ==================================== -->
                  <!-- v-model="form.phone_number" -->
                  <div
                    v-for="(number, index) in form.phone_number"
                    :key="index"
                  >
                    <v-text-field
                      v-model="number.phone"
                      label="Phone Number"
                      prepend-icon="mdi-cellphone"
                    ></v-text-field>
                  </div>
                  <v-btn x-small @click="addPhone">add</v-btn>
                  <!-- ==================================== -->

                  <v-text-field
                    v-model="form.password"
                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    :rules="[rules.required, rules.min]"
                    :type="showPassword ? 'text' : 'password'"
                    label="Password"
                    hint="At least 8 characters"
                    prepend-icon="mdi-key-variant"
                    @click:append="showPassword = !showPassword"
                  ></v-text-field>

                  <v-text-field
                    v-model="form.password_confirmation"
                    :append-icon="
                      showPasswordConfirm ? 'mdi-eye' : 'mdi-eye-off'
                    "
                    :rules="[rules.required, rules.min]"
                    :type="showPasswordConfirm ? 'text' : 'password'"
                    label="Password Confirmation"
                    hint="At least 8 characters"
                    prepend-icon="mdi-key-variant"
                    @click:append="showPasswordConfirm = !showPasswordConfirm"
                    :error-messages="errorsMessage.password"
                  ></v-text-field>
                </v-col>
                <v-col sm="4">
                  <v-list-item-avatar
                    tile
                    size="150"
                    color="grey lighten-2"
                    height="180"
                    class="rounded-sm"
                  >
                    <v-img
                      v-if="preview_profile"
                      :src="preview_profile"
                      class="img-fluid rounded-sm"
                    ></v-img>
                  </v-list-item-avatar>
                  <small class="red--text">{{ image_validation }}</small>
                  <!-- -btn-select-image -->
                  <div class="file-input ml-5">
                    <input
                      type="file"
                      name="file-input"
                      id="file-input"
                      class="file-input__input form-control-file"
                      @change="previewImage"
                    />
                    <label class="file-input__label" for="file-input">
                      <svg
                        aria-hidden="true"
                        focusable="false"
                        data-prefix="fas"
                        data-icon="upload"
                        class="svg-inline--fa fa-upload fa-w-16"
                        role="img"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"
                      >
                        <path
                          fill="currentColor"
                          d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z"
                        ></path>
                      </svg>
                      <span>Select Profile</span></label
                    >
                  </div>
                </v-col>
              </v-row>
            </v-card-text>
            <v-card-actions class="justify-end">
              <v-btn
                depressed
                dark
                color="grey lighten-1"
                small
                @click="closeDialog"
                >cancel</v-btn
              >
              <v-btn
                depressed
                dark
                color="indigo"
                small
                type="submit"
                :loading="btnSaveLoading"
                >save</v-btn
              >
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
    </div>
  </div>
</template>

<style scoped>
.file-input__input {
  width: 0.1px;
  height: 0.1px;
  opacity: 0;
  overflow: hidden;
  position: absolute;
  z-index: -1;
}

.file-input__label {
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  border-radius: 4px;
  font-size: 14px;
  color: #fff;
  font-size: 12px;
  padding: 2px 8px;
  background-color: #0d5ca7;
}

.file-input__label svg {
  height: 16px;
  margin-right: 4px;
}
</style>

<script>
export default {
  data() {
    return {
      editMode: false,
      search: "",
      snackbar: false,
      editMode: false,
      tableLoading: true,
      showPassword: false,
      showPasswordConfirm: false,
      headers: [
        {
          text: "No.",
          align: "start",
          value: "id",
        },
        { text: "Name", value: "name" },
        { text: "Email", value: "email" },
        { text: "Role", value: "role" },
        { text: "Phone", value: "phone" },
        { text: "Action", sortable: false, align: "center", value: "actions" },
      ],
      rules: {
        required: (value) => !!value || "Required.",
        min: (v) => v.length >= 8 || "Min 8 characters",
        emailMatch: () => `The email and password you entered don't match`,
      },
      userData: [],
      userCount: "",
      userForm: false,
      form: new Form({
        role_id: "",
        name: "",
        email: "",
        phone_number: [{ phone: "" }],
        image: null,
        password: "",
        password_confirmation: "",
      }),

      role: [
        { text: "Admin", value: 1 },
        { text: "User", value: 2 },
      ],
      preview_profile: null,
      btnSaveLoading: false,
      image_validation: "",
      alertSnackbarMsg: "",
      errorsMessage: "",
    };
  },

  computed: {
    formTitle() {
      return this.editMode === false ? "Add User" : "Edit User";
    },
  },
  mounted() {
    this.ReadUser();
  },

  methods: {
    ReadUser() {
      axios
        .get("http://127.0.0.1:8000/api/read-user", {
          headers: {
            Authorization:
              "Bearer " + "1|CRLpxKnDG2dZRnT26m2lUMdw09BiLv5If4YgEuLv",
          },
        })
        .then((response) => {
          this.userData = response.data.data;
          this.userCount = response.data.data.length;
          this.tableLoading = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    openDialog() {
      this.userForm = true;
    },

    closeDialog() {
      this.userForm = false;
      this.form.role_id = "";
      this.form.name = "";
      this.form.email = "";
      this.form.phone_number = "";
      this.form.profile = null;
      this.preview_profile = null;
      this.password = "";
      this.password_confirmation = "";
      this.tableLoading = false;
      this.errorsMessage = "";
      this.btnSaveLoading = false;
    },

    previewImage: function (event) {
      var input = event.target;
      if (input.files && input.files[0].size / (1024 * 1024) < 2) {
        var reader = new FileReader();
        reader.onload = (e) => {
          this.preview_profile = e.target.result;
        };
        this.form.image = input.files[0];
        reader.readAsDataURL(input.files[0]);
        this.image_validation = "";
      } else {
        this.image_validation = "Image must smaller then 2MB";
      }
    },

    addPhone: function () {
      this.form.phone_number.push({ phone: "" });
    },

    createPost() {
      this.btnSaveLoading = true;
      this.tableLoading = true;
      this.form
        .post("api/create-user", {
          headers: {
            Authorization:
              "Bearer " + "1|CRLpxKnDG2dZRnT26m2lUMdw09BiLv5If4YgEuLv",
          },
        })
        .then((response) => {
          this.ReadUser();
          this.closeDialog();
          this.image_validation = false;
          this.preview_profile = null;
          this.alertSnackbarMsg = response.data.message;
          this.snackbar = true;
        })
        .catch((errors) => {
          this.errorsMessage = errors.response.data.errors;
        });
    },
  },
};
</script>
