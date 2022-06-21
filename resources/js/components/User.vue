<template>
  <div id="user">
    <div>
      <v-row class="mb-1">
        <v-col cols="sm-8">
          <h3 class="grey--text text--darken-2">
            <v-icon class="mb-1" color="grey darken-2"
              >mdi-account-multiple</v-icon
            >
            <span class="text-decoration-underline">{{ $t('user.listTitle') }}</span>
            <v-chip color="grey lighten-2 grey--text text--darken-3">{{
              userCount
            }}</v-chip>
          </h3>
        </v-col>
        <v-col cols="sm-4" class="text-right">
          <v-btn
            small
            class="add-user white--text font-weight-regular khawin-background-color"
            @click="openDialog"
            ><v-icon left>mdi-plus</v-icon>{{ $t('user.btnAdd') }}</v-btn
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
            :footer-props="{
                'items-per-page-text':$t('user.tbPagination')
            }"
        >
          <template v-slot:[`item.id`]="item">
            {{ item.index + 1 }}
          </template>

          <template v-slot:[`item.name`]="{ item }">
            <v-avatar
              size="40"
              class="m-1"
              left
              v-if="item.profile == 'default.png'"
              color="cyan darken-2 white--text"
            >
              {{
                item.name
                  .split(" ")
                  .map((x) => x[0].toUpperCase())
                  .join("")
              }}
            </v-avatar>
            <v-avatar size="37" class="m-1" left v-else>
              <v-img :src="'/profiles/' + item.profile" />
            </v-avatar>

            <small
              class="
                font-weight-bold
                blue-grey--text
                text--darken-3 text-capitalize
                user-name
              "
            >
              {{ item.name }}
            </small>
          </template>

          <template v-slot:[`item.role`]="{ item }">
            <v-chip
              v-if="item.role == 'admin'"
              class="ma-2 text-capitalize role-chip"
              color="blue darken-2"
              text-color="white"
            >
              <v-avatar left>
                <v-icon>mdi-account-star</v-icon>
              </v-avatar>
              {{ item.role }}
            </v-chip>

            <v-chip
              v-else
              class="ma-2 text-capitalize role-chip"
              color="orange darken-2"
              text-color="white"
            >
              <v-avatar left>
                <v-icon>mdi-account-star</v-icon>
              </v-avatar>
              {{ item.role }}
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
            <v-icon x-small class="mr-2" @click="deleteUser(item.id, item.name)"
              >mdi-delete</v-icon
            >
          </template>
        </v-data-table>
      </v-card>

      <!-- --------User-Insert-Form------ -->
      <v-dialog v-model="userForm" width="550" persistent overlay-opacity="0">
        <v-card>
          <v-toolbar
            dense
            flat
            color="lighten-1"
            class="user-form-dialog khawin-background-color"
          >
            <span v-if="editMode === false" class="white--text khmer-font">
              <v-icon left color="white">mdi-account-plus</v-icon>
                {{ $t('user.frmTitleAdd') }}
            </span>
            <span v-else class="white--text khmer-font"
              ><v-icon left dark>mdi-account-edit</v-icon>{{ $t('user.frmTitleAdd') }}</span
            >
          </v-toolbar>

          <form
            @submit.prevent="editMode ? updateUser() : createPost()"
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
                    v-bind:label="$t('user.txtRole')"
                    class="khmer-font"
                    dense
                    color="cyan darken-1"
                    prepend-icon="mdi-account-star"
                    :error-messages="errorsMessage.role_id"
                  >
                  </v-select>

                  <v-text-field
                    v-model="form.name"
                    v-bind:label="$t('user.txtName')"
                    class="khmer-font"
                    color="cyan darken-1"
                    prepend-icon="mdi-account-edit"
                    :error-messages="errorsMessage.name"
                  ></v-text-field>

                  <v-text-field
                    v-model="form.email"
                    v-bind:label="$t('user.txtEmail')"
                    class="khmer-font"
                    color="cyan darken-1"
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
                            v-bind:label="$t('user.txtPhone')"
                            class="khmer-font"
                            color="cyan darken-1"
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
                    color="cyan darken-1"
                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    :type="showPassword ? 'text' : 'password'"
                    v-bind:label="$t('user.txtPassword')"
                    class="khmer-font"
                    hint="At least 8 characters"
                    prepend-icon="mdi-key-variant"
                    @click:append="showPassword = !showPassword"
                  ></v-text-field>

                  <v-text-field
                    v-model="form.password_confirmation"
                    color="cyan darken-1"
                    :append-icon="
                      showPasswordConfirm ? 'mdi-eye' : 'mdi-eye-off'
                    "
                    :type="showPasswordConfirm ? 'text' : 'password'"
                    v-bind:label="$t('user.txtPasswordConfir')"
                    class="khmer-font"
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

                    <v-img
                      v-if="
                        preview_profile_edit &&
                        preview_profile_edit != 'default.png'
                      "
                      :src="'/profiles/' + preview_profile_edit"
                      class="img-fluid rounded-sm"
                    ></v-img>
                  </v-list-item-avatar>
                  <v-file-input
                    show-size
                    v-model="form.image"
                    @change="onFileChange"
                    prepend-icon="mdi-camera"
                    v-bind:label="$t('user.txtImage')"
                    class="khmer-font"
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
                >{{ $t('user.btnCancel') }}</v-btn
              >
              <v-btn
                depressed
                dark
                class="khawin-background-color"
                small
                type="submit"
                :loading="btnSaveLoading"
                >{{ $t('user.btnSave') }}</v-btn
              >
            </v-card-actions>
          </form>
        </v-card>
      </v-dialog>
      <!-- ---------------Snacbar--------------- -->
      <v-snackbar v-model="snackbar" color="cyan darken-2" dark>
        {{ alertSnackbarMsg }}
        <template v-slot:action="{ attrs }">
          <v-btn dark text v-bind="attrs" @click="snackbar = false" small>
            {{ $t('user.msgClose') }}
          </v-btn>
        </template>
      </v-snackbar>

      <!-- ----------dialogDelete------------ -->
      <v-dialog v-model="dialogDelete" max-width="350px">
        <v-card>
          <div class="text-center">
            <v-sheet class="px-5 pt-7 pb-4 mx-auto text-center d-inline-block">
              <v-icon class="text-center pb-3" x-large color="red lighten-2"
                >mdi-alert</v-icon
              >
              <div class="grey--text text--darken-3 text-body-2 mb-4">
                {{ $t('user.deleteMessage') }}
                <b class="red--text tex--lighten-2">{{ userNameDelete }}</b> ?
              </div>

              <v-btn
                :disabled="btnLoading"
                class="ma-1"
                depressed
                small
                @click="dialogDelete = false"
              >
                {{ $t('user.btnCancel') }}
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
                {{ $t('user.btnDelete') }}
              </v-btn>
            </v-sheet>
          </div>
        </v-card>
      </v-dialog>
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
      userData: [],
      userCount: "",
      userForm: false,
      form: new Form({
        id: "",
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
      preview_profile_edit: null,
      btnSaveLoading: false,
      btnLoading: false,
      image_validation: "",
      alertSnackbarMsg: "",
      errorsMessage: "",
      dialogDelete: false,
      userNameDelete: "",
    };
  },

    computed: {
        formTitle() {
            return this.editMode === false ? "Add User" : "Edit User";
        },

        headers(){
            return[
                {
                    text: "#",
                    align: "start",
                    value: "id",
                },
                { text: this.$t('user.tbName'), value: "name" },
                { text: this.$t('user.tbEmail'), value: "email" },
                { text: this.$t('user.tbRole'), value: "role" },
                { text: this.$t('user.tbPhoneNum'), value: "phone" },
                { text: this.$t('user.tbUpdate_Delete'), sortable: false, align: "center", value: "actions" },
            ]
        }
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
                    Authorization: "Bearer " + localStorage.getItem("access_token"),
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
            this.editMode = false;
            this.userForm = false;
            this.form.role_id = "";
            this.form.name = "";
            this.form.email = "";
            this.form.phone_number = [{ phone: "" }];
            this.form.image = null;
            this.preview_profile = null;
            this.preview_profile_edit = null;
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
                Authorization: "Bearer " + localStorage.getItem("access_token"),
            },
            })
            .then((response) => {
                this.ReadUser();
                this.closeDialog();
                // this.alertSnackbarMsg = response.data.message;
                this.alertSnackbarMsg = this.$t('user.savedMsg');
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
        this.form.id = user.id;
        if (user.role == "admin") {
            this.form.role_id = 1;
        } else if (user.role == "user") {
            this.form.role_id = 2;
        }
        this.form.name = user.name;
        this.form.email = user.email;
        this.form.phone_number = user.phone;
        this.preview_profile_edit = user.profile;
        this.userForm = true;
        },

        async updateUser() {
        this.btnSaveLoading = true;
        this.tableLoading = true;
        await new Promise((resolve) => setTimeout(resolve, 1000));
        this.form
            .post("/api/update-user/" + this.form.id, {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("access_token"),
            },
            })
            .then((response) => {
                this.ReadUser();
                this.closeDialog();
                // this.alertSnackbarMsg = response.data.message;
                this.alertSnackbarMsg = this.$t('user.updateMsg');
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

        deleteUser(user, name) {
        this.form.id = user;
        this.userNameDelete = name;
        this.dialogDelete = true;
        },

        async submitDelete() {
        this.btnLoading = true;
        this.tableLoading = true;
        await new Promise((resolve) => setTimeout(resolve, 1000));
        axios
            .delete("/api/delete-user/" + this.form.id, {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("access_token"),
            },
            })
            .then((response) => {
                this.ReadUser();
                this.dialogDelete = false;
                // this.alertSnackbarMsg = response.data.message;
                this.alertSnackbarMsg = this.$t('user.deleteMsg');;
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
