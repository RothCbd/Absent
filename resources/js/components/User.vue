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

          <template v-slot:[`item.phone`]="{ item }">
            <span v-for="number in item.phone" :key="number.id">
              <v-chip
                small
                class="ma-1 user-phone-number"
                v-if="number.phone != null"
                label
                color="grey lighten-3"
              >
                <v-avatar left>
                  <v-icon>mdi-phone</v-icon>
                </v-avatar>
                {{ number.phone }}
              </v-chip>
            </span>
          </template>

          <template v-slot:[`item.actions`]="{ item }">
            <v-icon x-small class="mr-2" @click="editUser(item)"
              >mdi-pencil</v-icon
            >
            <v-icon x-small class="mr-2">mdi-delete</v-icon>
          </template>
        </v-data-table>
      </v-card>

      <!-- --------User-Insert-Form------ -->
      <v-dialog v-model="userForm" width="550" persistent overlay-opacity="0">
        <v-card>
          <v-toolbar
            dense
            flat
            color="indigo lighten-1"
            class="user-form-dialog"
          >
            <span v-if="editMode === false" class="white--text">
              <v-icon left color="white">mdi-account-plus</v-icon>
              {{ formTitle }}
            </span>
            <span v-else class="white--text"
              ><v-icon left dark>mdi-account-edit</v-icon>{{ formTitle }}</span
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
                  <v-row>
                    <v-col sm="11">
                      <span
                        v-for="(number, index) in form.phone_number"
                        :key="index"
                      >
                        <v-text-field
                          v-model="number.phone"
                          label="Phone Number"
                          prepend-icon="mdi-phone"
                          v-mask="'###-###-####'"
                        ></v-text-field>
                        <small v-if="index !== 0" class="btn-remove-phoneNum">
                          <v-btn
                            fab
                            depressed
                            x-small
                            color="red"
                            dark
                            @click="removePhone(index)"
                            ><v-icon>mdi-close</v-icon></v-btn
                          >
                        </small>
                      </span>
                    </v-col>
                    <v-col sm="1">
                      <v-btn
                        fab
                        depressed
                        x-small
                        @click="addPhone"
                        color="teal"
                        class="btn-add-phoneNum"
                      >
                        <v-icon small class="white--text">mdi-plus</v-icon>
                      </v-btn>
                    </v-col>
                  </v-row>

                  <!-- ==================================== -->

                  <v-text-field
                    v-model="form.password"
                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
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
                  <v-file-input
                    show-size
                    v-model="form.image"
                    @change="onFileChange"
                    prepend-icon="mdi-camera"
                    label="profile image"
                    @click:clear="clearImage()"
                    :error-messages="errorsMessage.image"
                  />
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
    this.activateMultipleDraggableDialogs();
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
      this.form.phone_number = [{ phone: "" }];
      this.form.image = null;
      this.preview_profile = null;
      this.form.password = "";
      this.form.password_confirmation = "";
      this.tableLoading = false;
      this.errorsMessage = "";
      this.btnSaveLoading = false;
    },

    addPhone: function () {
      this.form.phone_number.push({ phone: "" });
    },

    removePhone(index) {
      this.form.phone_number.splice(index, 1);
    },
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

    clearImage() {
      this.preview_profile = null;
      this.form.image = null;
    },
    // ---------------------------------

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
          this.btnSaveLoading = false;
          this.tableLoading = false;
        })
        .catch((errors) => {
          this.errorsMessage = errors.response.data.errors;
          this.btnSaveLoading = false;
          this.tableLoading = false;
        });
    },

    editUser(user) {
      this.editMode = true;
      console.log(user);
      if (user.role == "admin") {
        this.form.role_id = 1;
      } else if (user.role == "user") {
        this.form.role_id = 2;
      }
      this.form.name = user.name;
      this.form.email = user.email;
      this.form.phone_number = user.phone;

      this.userForm = true;
    },
  },
};
</script>
