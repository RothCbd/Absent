<template>
  <div id="employee">
    <div>
      <v-row>
        <v-col cols="sm-8">
          <h5 class="grey--text text--darken-2">
            <v-icon class="mb-1" color="grey darken-2">mdi-account-tie</v-icon>
            <span class="text-decoration-underline">Employees List</span>
            <v-chip color="grey lighten-2 grey--text text--darken-3">{{
              employeeCount
            }}</v-chip>
          </h5>
        </v-col>
        <v-col cols="sm-4" class="text-right">
          <v-btn
            small
            color="indigo"
            class="add-user white--text pa-2 font-weight-regular mb-2"
            @click="openDialog"
            ><v-icon left>mdi-plus</v-icon> Add employee</v-btn
          >
        </v-col>
      </v-row>

      <!-- -------table---- -->
      <v-card class="mx-auto table-card">
        <v-data-table
          :headers="headers"
          :items="employeeData"
          :search="search"
          :loading="tableLoading"
          loading-text="Loading users data"
        >
          <template v-slot:[`item.id`]="item">
            {{ item.index + 1 }}
          </template>

          <template v-slot:[`item.name`]="{ item }">
            <v-avatar
              size="40"
              class="ma-2"
              left
              v-if="item.image == 'default.png'"
            >
              <v-img :src="'/image/default.png'" />
            </v-avatar>
            <v-avatar size="40" class="ma-2" left v-else>
              <v-img :src="'/employees/' + item.image" />
            </v-avatar>

            <small
              class="
                font-weight-medium
                blue-grey--text
                text--darken-3 text-capitalize
                employee-name
              "
            >
              {{ item.name }}
            </small>
          </template>

          <template v-slot:[`item.gender`]="{ item }">
            <v-chip
              v-if="item.gender == 'male'"
              color="primary"
              class="text-capitalize p-2"
              small
            >
              {{ item.gender }}
            </v-chip>
            <v-chip v-else color="pink" dark class="text-capitalize p-2" small>
              {{ item.gender }}
            </v-chip>
          </template>

          <template v-slot:[`item.position`]="{ item }">
            <v-chip
              label
              dark
              color="blue-grey darken-2"
              class="text-capitalize p-2"
              small
            >
              {{ item.position }}
            </v-chip>
          </template>

          <template v-slot:[`item.start_date`]="{ item }">
            <v-chip
              class="p-1 start-date"
              small
              color="teal"
              text-color="white"
              label
            >
              <v-avatar left class="mr-0">
                <v-icon x-small>mdi-calendar-month</v-icon>
              </v-avatar>
              {{ item.start_date }}
            </v-chip>
          </template>

          <template v-slot:[`item.actions`]="{ item }">
            <v-icon small class="mr-2">mdi-pencil</v-icon>
            <v-icon small class="mr-2">mdi-delete</v-icon>
          </template>
        </v-data-table>
      </v-card>

      <!-- --------employee-Insert-Form------ -->
      <v-dialog
        v-model="employeeForm"
        width="550"
        persistent
        overlay-opacity="0"
      >
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
          >
            <v-card-text>
              <v-row>
                <v-col sm="8">
                  <v-text-field
                    v-model="form.name"
                    label="Name"
                    prepend-icon="mdi-account-tie"
                    :error-messages="errorsMessage.name"
                  ></v-text-field>

                  <v-radio-group
                    v-model="form.gender"
                    row
                    :error-messages="errorsMessage.gender"
                    class="p-0 m-0 ml-5"
                  >
                    <v-chip class="p-1" small>
                      <v-radio label="Male" value="male"></v-radio>
                    </v-chip>
                    <v-chip class="ml-2 p-1" small>
                      <v-radio label="Female" value="female"></v-radio>
                    </v-chip>
                  </v-radio-group>

                  <v-text-field
                    v-model="form.email"
                    label="Email"
                    prepend-icon="mdi-email"
                    :error-messages="errorsMessage.email"
                  ></v-text-field>

                  <v-text-field
                    v-model="form.position"
                    label="Position"
                    prepend-icon="mdi-clipboard-account"
                    :error-messages="errorsMessage.position"
                  ></v-text-field>

                  <v-text-field
                    v-model="form.start_date"
                    v-mask="'##-##-####'"
                    label="Start Date"
                    prepend-icon="mdi-calendar-range"
                    :error-messages="errorsMessage.position"
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
                          <v-icon @click="removePhone(index)">mdi-close</v-icon>
                        </small>
                      </span>
                    </v-col>
                    <v-col sm="1">
                      <v-icon class="icon-add-phone" @click="addPhone"
                        >mdi-plus</v-icon
                      >
                    </v-col>
                  </v-row>
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
                    prepend-icon="mdi-image-multiple"
                    label="employee image"
                    @click:clear="clearImage()"
                    :error-messages="errorsMessage.image"
                  />
                </v-col>
              </v-row>
            </v-card-text>

            <v-card-actions class="card-action">
              <v-spacer></v-spacer>
              <v-btn
                small
                color="grey lighten-2"
                depressed
                @click="closeDialog"
              >
                cancel
              </v-btn>
              <v-btn
                color="primary"
                small
                depressed
                type="submit"
                :loading="btnSaveLoading"
              >
                save
              </v-btn>
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

<script>
export default {
  data() {
    return {
      editMode: false,
      search: "",
      snackbar: false,
      editMode: false,
      tableLoading: true,
      headers: [
        {
          text: "No.",
          align: "start",
          value: "id",
        },
        { text: "Name", value: "name" },
        { text: "Gender", value: "gender" },
        { text: "Email", value: "email" },
        { text: "Position", value: "position" },
        { text: "Start Date", value: "start_date" },
        { text: "Phone", value: "phone" },
        { text: "Action", sortable: false, align: "center", value: "actions" },
      ],
      employeeData: [],
      employeeCount: "",
      employeeForm: false,
      form: new Form({
        id: "",
        name: "",
        gender: "",
        email: "",
        start_date: "",
        position: "",
        phone_number: [{ phone: "" }],
        image: null,
      }),

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
      return this.editMode === false ? "Add Employee" : "Edit Employee";
    },
  },
  mounted() {
    this.ReadEmployee();
    this.activateMultipleDraggableDialogs();
  },

  methods: {
    ReadEmployee() {
      axios
        .get("http://127.0.0.1:8000/api/read-employee", {
          headers: {
            Authorization:
              "Bearer " + "3|0sgWurjPC0veVBPSbxO63eTcNEBpSIJDOnQnGGRg",
          },
        })
        .then((response) => {
          console.log(response);

          this.employeeData = response.data.data;
          this.employeeCount = response.data.data.length;
          this.tableLoading = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    addPhone: function () {
      this.form.phone_number.push({ phone: "" });
    },

    removePhone(index) {
      this.form.phone_number.splice(index, 1);
    },

    openDialog() {
      this.employeeForm = true;
    },

    closeDialog() {
      this.employeeForm = false;
      this.form.role_id = "";
      this.form.name = "";
      this.form.email = "";
      this.form.gender = null;
      this.form.position = "";
      this.form.phone_number = [{ phone: "" }];
      this.form.image = null;
      this.form.start_date = "";
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
    // -------------image--------------------
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
        .post("api/create-employee", {
          headers: {
            Authorization:
              "Bearer " + "3|0sgWurjPC0veVBPSbxO63eTcNEBpSIJDOnQnGGRg",
          },
        })
        .then((response) => {
          this.ReadEmployee();
          this.closeDialog();
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
  },
};
</script>
